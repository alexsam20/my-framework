<?php

namespace app\Controllers;

use core\Application;

class HomeController extends BaseController
{
    public function index()
    {
        /*if (session()->has('global')) {
            session()->set('global', date('Y-m-d H:i:s') . '--NikNumber0045');
        }*/
//        $post = db()->findOrFail('posts', 'id', 3);
        $posts = db()->findAll('posts');
        return view('main', ['title' => 'Home Page', 'posts' => $posts]);
    }
}