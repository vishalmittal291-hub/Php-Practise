<?php

// Every request funnels through here — .htaccess (and tasks.json's
// dev server command) both point straight at this file.
define('BASE_PATH', __DIR__);

require BASE_PATH . '/functions.php'; // our global helpers: abort(), e(), old(), urlIs()
require BASE_PATH . '/autoload.php';  // lets us use the `use App\...` lines just below

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\NotesController;

$router = new Router();

// The simple static pages.
$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);
$router->get('/contact', [HomeController::class, 'contact']);

// Notes: list, create, edit/update, and delete.
$router->get('/notes', [NotesController::class, 'index']);
$router->any('/notes/create', [NotesController::class, 'create']); // GET shows the form, POST saves it
$router->get('/notes/{id}', [NotesController::class, 'edit']);      // GET shows the form, POST updates it
$router->post('/notes/{id}', [NotesController::class, 'edit']);
$router->post('/notes/{id}/delete', [NotesController::class, 'destroy']);

// Now that every route is registered, actually match and run one.
$router->direct($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
