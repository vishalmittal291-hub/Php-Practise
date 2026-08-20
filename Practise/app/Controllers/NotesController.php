<?php

namespace App\Controllers;

use App\Database;
use App\Validator;

// Handles everything under /notes — listing, creating, editing, and
// deleting. index.php routes all of that here.
class NotesController
{
    protected Database $db;

    public function __construct()
    {
        $config = require BASE_PATH . '/config.php';
        $this->db = Database::connect($config['db']);
    }

    // GET /notes — just shows everyone's notes, newest first.
    public function index(): void
    {
        $notes = $this->db->get('SELECT id, body, created_at FROM notes ORDER BY created_at DESC');
        $heading = 'Notes';

        require BASE_PATH . '/views/notes.view.php';
    }

    // GET /notes/create shows a blank form.
    // POST /notes/create validates what was submitted and, if it's good, saves it.
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

            // Validation failed — keep whatever they typed so they don't lose it.
            $old = $_POST;
        }

        require BASE_PATH . '/views/note.view.php';
    }

    // Same idea as create(), just aimed at an existing note: GET shows
    // the form pre-filled, POST saves the changes. Basically create()
    // rewritten to UPDATE instead of INSERT, reusing the same view.
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

                header('Location: /notes');
                die();
            }

            $old = $_POST;
        }

        require BASE_PATH . '/views/note.view.php';
    }

    // POST /notes/{id}/delete — no confirmation here server-side, the
    // "are you sure?" prompt lives in the view's onsubmit handler.
    public function destroy(string $id): void
    {
        $note = $this->findOrAbort($id);
        $this->authorize($note);

        $this->db->query('DELETE FROM notes WHERE id = :id', ['id' => $id]);

        header('Location: /notes');
        die();
    }

    // Looks up a note by id, or gives up with a 404 if it doesn't exist.
    protected function findOrAbort(string $id): array
    {
        $note = $this->db->find('SELECT * FROM notes WHERE id = :id', ['id' => $id]);

        if (!$note) {
            abort(404);
        }

        return $note;
    }

    // Notes aren't tied to user accounts here — just to whoever's
    // session created them. So only that same session can edit or
    // delete it; anyone else gets bounced to the 403 page.
    protected function authorize(array $note): void
    {
        if ($note['owner_token'] !== $this->ownerToken()) {
            abort(403);
        }
    }

    // Gives each visitor a random, persistent token in their session
    // the first time they need one, and reuses it after that.
    protected function ownerToken(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return $_SESSION['owner_token'] ??= bin2hex(random_bytes(16));
    }
}
