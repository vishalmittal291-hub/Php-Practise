<?php

// This is just our settings file for connecting to the database.
// NotesController grabs this in its constructor and hands it straight
// to Database::connect() — nothing fancy happening here.
return [
    'db' => [
        'host' => getenv('DB_HOST') ?: 'localhost',
        'port' => (int) (getenv('DB_PORT') ?: 3306),
        'dbname' => getenv('DB_DATABASE') ?: 'test',
        'charset' => 'utf8mb4',
        'user' => getenv('DB_USERNAME') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: '',
    ],
];
