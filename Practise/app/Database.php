<?php

namespace App;

use PDO;

// A thin wrapper around PDO so the rest of the app doesn't have to
// deal with connection strings and prepared statements directly.
//
// NOTE: this replaces the flat query()-only version — NotesController
// was already written against this connect()/get()/find() API, so
// without this the whole app would fatal-error before rendering anything.
class Database
{
    protected PDO $connection;

    // Keeps one shared connection alive instead of reconnecting on
    // every single call to Database::connect().
    protected static ?Database $instance = null;

    private function __construct(array $db)
    {
        $dsn = "mysql:host={$db['host']};port={$db['port']};dbname={$db['dbname']};charset={$db['charset']}";

        $this->connection = new PDO($dsn, $db['user'], $db['password']);

        // Throw exceptions on failure instead of silently returning false —
        // makes bugs much easier to spot.
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Hands back the shared connection, creating it the first time it's needed.
    public static function connect(array $db): self
    {
        if (self::$instance === null) {
            self::$instance = new self($db);
        }

        return self::$instance;
    }

    // Runs any query with bound :params and gives back the raw statement,
    // for whenever you need more control (INSERT/UPDATE/DELETE mostly).
    public function query(string $sql, array $params = []): \PDOStatement
    {
        $statement = $this->connection->prepare($sql);
        $statement->execute($params);

        return $statement;
    }

    // For SELECTs where you want every matching row back.
    public function get(string $sql, array $params = []): array
    {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    // For SELECTs where you only expect (or only care about) one row.
    // Returns false if nothing matched, so callers can just do `if (!$note)`.
    public function find(string $sql, array $params = []): array|false
    {
        $row = $this->query($sql, $params)->fetch(PDO::FETCH_ASSOC);

        return $row === false ? false : $row;
    }
}
