<?php

namespace app\Controllers;

use core\Application;
use core\Controller;

class ContactController extends Controller
{
    public function index()
    {
        $title = 'Contact Title Page';
        $name = 'John Kerry';
        return view('contact', compact('title','name'));
        /*return view('contact', ['title' => 'Contact Title Page', 'name' => 'John Kerry']);*/
        /*
          It's works
        return view()->render('contact');
        return $this->render('contact');
        return app()->view->render('contact');
        */
    }

    public function send()
    {
        return 'Contact form POST Page';
    }
}