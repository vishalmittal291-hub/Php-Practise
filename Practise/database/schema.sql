-- Adds the `notes` table if it doesn't exist yet, and — since your
-- existing table is missing a couple of columns this app needs —
-- adds those on top of whatever's already there. Safe to run more
-- than once. Run with: mysql -u root test < database/schema.sql

CREATE TABLE IF NOT EXISTS notes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    body TEXT NOT NULL
);

-- Ties a note to whichever session created it, so we know who's
-- allowed to edit or delete it later.
ALTER TABLE notes ADD COLUMN IF NOT EXISTS owner_token VARCHAR(64) NOT NULL DEFAULT '';

ALTER TABLE notes ADD COLUMN IF NOT EXISTS created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

-- Notes are listed newest-first, so an index here keeps that fast.
ALTER TABLE notes ADD INDEX IF NOT EXISTS idx_notes_created_at (created_at);
