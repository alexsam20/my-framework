<?php

namespace app\Controllers;

use core\Application;

class HomeController extends BaseController
{
    public function index()
    {
        $post = db()->findOrFail('posts', 'id', 3);
        $posts = db()->findAll('posts');
        return view('main', ['title' => 'Home Page', 'post' => $post]);
    }
}