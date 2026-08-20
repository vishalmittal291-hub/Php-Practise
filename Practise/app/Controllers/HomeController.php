<?php

namespace App\Controllers;

// Routed from index.php for the static pages.
class HomeController
{
    public function index(): void
    {
        $heading = 'Home';
        require BASE_PATH . '/views/index.view.php';
    }

    public function about(): void
    {
        $heading = 'About';
        require BASE_PATH . '/views/about.view.php';
    }

    public function contact(): void
    {
        $heading = 'Contact';
        require BASE_PATH . '/views/contact.view.php';
    }
}
