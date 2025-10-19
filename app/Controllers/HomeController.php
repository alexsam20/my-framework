<?php

namespace app\Controllers;

use core\Application;

class HomeController extends BaseController
{
    public function index()
    {
        $posts = db()->findAll('posts');
        return view('main', ['title' => 'Home Page', 'posts' => $posts]);
    }
}