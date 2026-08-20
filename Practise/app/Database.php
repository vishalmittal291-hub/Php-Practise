<?php

namespace App;

use PDO;

// PDO wrapper, instantiated via connect() from NotesController.
class Database
{
    protected static ?Database $instance = null;

    public PDO $connection;

    private function __construct(array $config)
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";

        $this->connection = new PDO($dsn, $config['user'], $config['password']);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Shares one connection app-wide instead of opening a new one per call.
    public static function connect(array $config): static
    {
        return static::$instance ??= new static($config);
    }

    // Prepared statement with bound params -- prevents SQL injection.
    public function query(string $query, array $params = [])
    {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);

        return $statement;
    }

    public function get(string $query, array $params = []): array
    {
        return $this->query($query, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(string $query, array $params = []): array|false
    {
        return $this->query($query, $params)->fetch(PDO::FETCH_ASSOC);
    }
}
