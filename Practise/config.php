<?php

// Read by NotesController's constructor and passed to Database::connect().
return [
    'db' => [
        'host' => getenv('DB_HOST') ?: 'localhost',
        'port' => (int) (getenv('DB_PORT') ?: 3306),
        'dbname' => getenv('DB_DATABASE') ?: 'practise',
        'charset' => 'utf8mb4',
        'user' => getenv('DB_USERNAME') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: '',
    ],
];
