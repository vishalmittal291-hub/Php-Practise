# Practise

A small PHP Notes app built from scratch, without a framework — just plain PHP, PDO, and a hand-rolled router and autoloader. Built as a practice project to work through core backend concepts: routing, request handling, database access, validation, and basic authorization.

## Features

- Full CRUD for notes (create, list, edit, delete)
- Session-based "ownership" — each visitor gets a random token, and only the session that created a note can edit or delete it
- Server-side form validation with inline error messages and repopulated fields on failure
- Custom router supporting static and dynamic (`/notes/{id}`) routes, matched per HTTP verb
- All queries use prepared statements — no raw string-concatenated SQL
- All output is escaped before rendering

## Tech stack

- PHP 8+ (uses constructor property promotion, `match`, union types, `str_starts_with`/`str_ends_with`)
- MySQL / MariaDB via PDO
- Tailwind CSS (via CDN — no build step)

## Project structure

```
practise/
├── app/
│   ├── Router.php              # matches requests to controller actions
│   ├── Database.php            # PDO wrapper: connect() / query() / get() / find()
│   ├── Validator.php           # simple rule-based form validation
│   └── Controllers/
│       ├── HomeController.php  # static pages: home, about, contact
│       └── NotesController.php # notes CRUD + authorization
├── database/
│   └── schema.sql              # creates/repairs the notes table
├── views/
│   ├── *.view.php              # one file per page
│   └── partials/                # shared layout: head, nav, banner, footer, mobile menu
├── config.php                  # DB connection settings (env-var driven)
├── functions.php               # global helpers: e(), old(), abort(), urlIs()
├── autoload.php                # hand-rolled PSR-4-ish autoloader for App\...
├── index.php                   # entry point — registers routes and dispatches
└── .htaccess                   # rewrites all requests to index.php (Apache)
```

## Setup

1. **Database.** Create a database and add the `notes` table:
   ```
   mysql -u root -p your_database < database/schema.sql
   ```
   The script is safe to run against an existing `notes` table too — it only adds columns that are missing.

2. **Configuration.** `config.php` reads connection settings from environment variables, falling back to local defaults if they're unset:

   | Variable       | Default     |
   |----------------|-------------|
   | `DB_HOST`      | `localhost` |
   | `DB_PORT`      | `3306`      |
   | `DB_DATABASE`  | `test`      |
   | `DB_USERNAME`  | `root`      |
   | `DB_PASSWORD`  | *(empty)*   |

   Adjust the defaults in `config.php` or set the environment variables to match your setup.

3. **Run it.**
   ```
   php -S localhost:8000 index.php
   ```
   then visit `http://localhost:8000`.

   Or serve it with Apache (XAMPP, etc.) — the included `.htaccess` handles the routing, as long as `AllowOverride All` is set for the directory.

   > **Note:** tools that serve static files only (like VS Code's "Live Server" or "PHP Server" extensions run without a router script) won't execute PHP for every route correctly. Use the command above, or a real Apache/PHP setup.

## Routes

| Method | Path                  | Action                          |
|--------|------------------------|----------------------------------|
| GET    | `/`                    | Home page                       |
| GET    | `/about`                | About page                      |
| GET    | `/contact`              | Contact page                    |
| GET    | `/notes`                | List all notes                  |
| GET/POST | `/notes/create`       | New note form / save            |
| GET/POST | `/notes/{id}`         | Edit note form / update         |
| POST   | `/notes/{id}/delete`    | Delete a note                   |

## License

Free to use for learning purposes.
