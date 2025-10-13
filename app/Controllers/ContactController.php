<?php

namespace app\Controllers;

use app\Models\Contact;
use core\Application;
use core\Controller;

class ContactController extends Controller
{
    public function index(): false|string|\core\View
    {
        $title = 'Contact Title Page';
        $name = 'John Kerry';
        return view('contact', compact('title','name'));
        /*
          It's works
          return view('contact', ['title' => 'Contact Title Page', 'name' => 'John Kerry']);
          It's works to
          return view()->render('contact');
          return $this->render('contact');
          return app()->view->render('contact');
        */
    }

    public function send()
    {
        $model = new Contact();
        $model->loadData();
        if (!$model->validate()) {
            return view('contact', ['title' => 'Contact Form', 'errors' => $model->getErrors()]);
        }
        response()->redirect('/');

        return 'Contact form POST Page';
    }
}