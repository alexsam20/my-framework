<?php

namespace app\Controllers;

use app\Models\Post;

class PostController extends BaseController
{
    public function create(): false|string|\core\View
    {
        return view('/posts/create', ['title' => 'Create post']);
    }

    public function store()
    {
        if (request()->isPost()) {
            $model = new Post();
            $model->loadData();
            if (!$model->validate()) {
                return view('/posts/create', ['title' => 'Create post', 'errors' => $model->getErrors()]);
            }

            if ($id = $this->db->insert('posts', $model->attributes)) {
                session()->setFlash('success', "Post $id created");
            } else {
                session()->setFlash('error', 'Unknown errors');
            }
            response()->redirect('/posts/create');
        }

        return 'OK';
    }
}