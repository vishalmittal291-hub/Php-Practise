<?php

// Entry point: .htaccess / tasks.json route every request here.
define('BASE_PATH', __DIR__);

require BASE_PATH . '/functions.php'; // global helpers: abort(), e(), old(), urlIs()
require BASE_PATH . '/autoload.php';  // enables the `use App\...` lines below

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\NotesController;

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/about', [HomeController::class, 'about']);
$router->get('/contact', [HomeController::class, 'contact']);

$router->get('/notes', [NotesController::class, 'index']);
$router->any('/notes/create', [NotesController::class, 'create']); // GET shows form, POST saves
$router->get('/notes/{id}', [NotesController::class, 'edit']);      // GET shows form, POST updates
$router->post('/notes/{id}', [NotesController::class, 'edit']);
$router->post('/notes/{id}/delete', [NotesController::class, 'destroy']);

$router->direct($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
