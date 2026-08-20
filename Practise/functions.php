<?php

// Our little toolbox of global helpers — loaded by index.php before
// anything else runs, so every one of these is available everywhere.

// Quick and dirty "dump and die" for when you just want to see what's
// inside a variable and stop the request right there.
function dd($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';

    die();
}

// Tells us whether the given path matches the page we're currently on —
// handy in nav.php for highlighting the active link.
function urlIs($value)
{
    return $_SERVER['REQUEST_URI'] === $value;
}

// Bails out of the request with an HTTP status code and shows the
// matching error view. Used by the router and by NotesController
// whenever something isn't found or isn't allowed.
function abort($code = 404)
{
    http_response_code($code);

    require BASE_PATH . "/views/{$code}.view.php";

    die();
}

// Never trust anything before it hits the page — this escapes it first.
function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

// After a form submission fails validation, this brings back whatever
// the user typed so they don't have to start over from scratch.
function old($key, array $old = [], $default = '')
{
    return e($old[$key] ?? $default);
}
