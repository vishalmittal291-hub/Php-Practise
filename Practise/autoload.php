<?php

// A small hand-rolled autoloader so we never have to write manual
// `require` statements for our own classes. Whenever PHP hits a class
// like App\Foo\Bar that it doesn't recognize yet, this function gets
// a chance to load it — in this case from app/Foo/Bar.php.
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = BASE_PATH . '/app/';

    // Not one of ours — leave it for another autoloader (or a fatal error).
    if (!str_starts_with($class, $prefix)) {
        return;
    }

    // Turn App\Controllers\HomeController into app/Controllers/HomeController.php
    $relativeClass = substr($class, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (is_file($file)) {
        require $file;
    }
});
