<?php

namespace App\Controllers;

// The three simple static pages — nothing dynamic happening here,
// each action just points to its matching view.
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
