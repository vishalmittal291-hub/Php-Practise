# Practise — PHP for Beginners project, through "Build a Better Router"

This fills in the two empty stub views (`note.view.php`, `notes.view.php`) and
finishes the app as a small **Notes** CRUD project, wired up the way the
listed lessons build toward it.

## Setup

1. Import the schema: `mysql -u root < database/schema.sql`
   (creates the `practise` database and a `notes` table).
2. `config.php` reads DB credentials from environment variables first
   (`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`), and
   falls back to the same local defaults as before if they're unset.
3. Run it: `php -S localhost:8000 index.php` (already in `tasks.json`).
4. Visit `/`, `/about`, `/contact`, and `/notes`.

## Where each topic landed

**Dynamic Web Applications**
- *Page Links / Superglobals & current-page styling* — `urlIs()` in
  `functions.php`, used in `nav.php`.
- *PHP Partials* — `views/partials/*`.
- *Make a PHP Router → Build a Better Router* — the old function-based
  `router.php` is replaced by `app/Router.php`, a class that registers
  routes per HTTP verb, matches `{id}`-style dynamic segments with a regex,
  and dispatches to a `[Controller::class, 'method']` pair.
- *Create a MySQL Database / PDO First Steps* — `database/schema.sql`.
- *Extract a PHP Database Class* — `app/Database.php`, now with a small
  `connect()`/`get()`/`find()` API on top of the original `query()`.
- *Environments and Configuration Flexibility* — `config.php` reads from
  `getenv()` with local fallbacks.
- *SQL Injection Vulnerabilities Explained* — every query in
  `NotesController` is a prepared statement with bound `:params`, never
  string-concatenated SQL.

**Notes Mini-Project**
- *Database Tables and Indexes* — `notes` table with an index on
  `created_at` (`database/schema.sql`).
- *Render the Notes and Note Page* — `views/notes.view.php` (list) and
  `views/note.view.php` (single form).
- *Introduction to Authorization* — `NotesController::authorize()`: a note
  carries an `owner_token` tied to the visitor's session, and only that
  session may edit or delete it (`views/403.view.php` for the rejection).
- *Programming is Rewriting* — `edit()` is literally `create()` rewritten:
  same view, same validation, swapped from `INSERT` to `UPDATE`.
- *Intro to Forms and Request Methods* / *Handle Multiple Request Methods
  From a Controller Action* — `create()` and `edit()` each check
  `$_SERVER['REQUEST_METHOD']` and do double duty: show the form on `GET`,
  process it on `POST`.
- *Always Escape Untrusted Input* — `e()` and `old()` in `functions.php`;
  every value printed in `note.view.php` / `notes.view.php` goes through one
  of them.
- *Intro to Form Validation / Extract a Simple Validator Class* —
  `app/Validator.php`, called from both `create()` and `edit()`.

**Project Organization**
- *Resourceful Naming Conventions* — controller actions named `index`,
  `create`, `edit`, `destroy` (create/store and edit/update are merged per
  the "multiple request methods" lesson above, rather than split further).
- *PHP Autoloading and Extraction* — `autoload.php`, a hand-rolled
  PSR-4-ish autoloader.
- *Namespacing* — `App\Router`, `App\Database`, `App\Validator`,
  `App\Controllers\*`.
- *Handle Multiple Request Methods From a Controller Action* /
  *Build a Better Router* — see above.

## Note on one bug fix

`views/partials/mobile-menu.php` had its `<script>` commented out in the
original upload, which meant the mobile menu button and profile dropdown
did nothing. Uncommented it so they actually work.
