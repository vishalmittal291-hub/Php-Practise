<?php

// Global helpers, loaded by index.php before anything else runs.

function dd($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';

    die();
}

// Used in nav.php to highlight the current page.
function urlIs($value)
{
    return $_SERVER['REQUEST_URI'] === $value;
}

// Called by app/Router.php and NotesController to bail out with a status + matching view.
function abort($code = 404)
{
    http_response_code($code);

    require BASE_PATH . "/views/{$code}.view.php";

    die();
}

// Escapes any value before it hits the page.
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// Re-populates a form field from $old after a failed submission (note.view.php).
function old($key, array $old = [], $default = '')
{
    return e($old[$key] ?? $default);
}
