<?php

namespace App\Controllers;

use App\Database;
use App\Validator;

// Routed from index.php for every /notes route.
class NotesController
{
    protected Database $db;

    public function __construct()
    {
        $config = require BASE_PATH . '/config.php';
        $this->db = Database::connect($config['db']);
    }

    // GET /notes -> views/notes.view.php
    public function index(): void
    {
        $notes = $this->db->get('SELECT id, body, created_at FROM notes ORDER BY created_at DESC');
        $heading = 'Notes';

        require BASE_PATH . '/views/notes.view.php';
    }

    // GET /notes/create shows a blank form; POST validates & saves it.
    public function create(): void
    {
        $errors = [];
        $old = ['body' => ''];
        $heading = 'New Note';
        $mode = 'create';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = Validator::validate($_POST, [
                'body' => 'required|min:3|max:1000',
            ]);

            if (!$errors) {
                $this->db->query(
                    'INSERT INTO notes (body, owner_token) VALUES (:body, :owner_token)',
                    ['body' => $_POST['body'], 'owner_token' => $this->ownerToken()]
                );

                header('Location: /notes');
                die();
            }

            $old = $_POST;
        }

        require BASE_PATH . '/views/note.view.php';
    }

    // GET /notes/{id} shows the same form pre-filled; POST updates it.
    // create() rewritten to UPDATE instead of INSERT, reusing the same view.
    public function edit(string $id): void
    {
        $note = $this->findOrAbort($id);
        $this->authorize($note);

        $errors = [];
        $old = $note;
        $heading = 'Edit Note';
        $mode = 'edit';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = Validator::validate($_POST, [
                'body' => 'required|min:3|max:1000',
            ]);

            if (!$errors) {
                $this->db->query(
                    'UPDATE notes SET body = :body WHERE id = :id',
                    ['body' => $_POST['body'], 'id' => $id]
                );

                header("Location: /notes/{$id}");
                die();
            }

            $old = $_POST;
        }

        require BASE_PATH . '/views/note.view.php';
    }

    // POST /notes/{id}/delete
    public function destroy(string $id): void
    {
        $note = $this->findOrAbort($id);
        $this->authorize($note);

        $this->db->query('DELETE FROM notes WHERE id = :id', ['id' => $id]);

        header('Location: /notes');
        die();
    }

    protected function findOrAbort(string $id): array
    {
        $note = $this->db->find('SELECT * FROM notes WHERE id = :id', ['id' => $id]);

        if (!$note) {
            abort(404);
        }

        return $note;
    }

    // Only the session that created a note may edit or delete it.
    protected function authorize(array $note): void
    {
        if ($note['owner_token'] !== $this->ownerToken()) {
            abort(403);
        }
    }

    protected function ownerToken(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return $_SESSION['owner_token'] ??= bin2hex(random_bytes(16));
    }
}
