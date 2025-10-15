<?php

namespace app\Controllers;

use app\Models\Post;

class PostController extends BaseController
{
    public function create()
    {
        return view('posts/create', ['title' => 'Create post']);
    }

    public function store()
    {
        if (request()->isPost()) {
            $model = new Post();
            $model->loadData();
            if (!$model->validate()) {
                return view('posts/create', ['title' => 'Create post', 'errors' => $model->getErrors()]);
            }
        }

        return 'OK';
    }
}