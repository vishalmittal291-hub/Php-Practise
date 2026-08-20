-- Run once: mysql -u root < database/schema.sql
CREATE DATABASE IF NOT EXISTS practise;
USE practise;

CREATE TABLE IF NOT EXISTS notes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    body TEXT NOT NULL,
    owner_token VARCHAR(64) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY idx_notes_created_at (created_at)
);
