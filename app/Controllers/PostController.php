<?php

namespace app\Controllers;

use app\Models\Post;

class PostController extends BaseController
{
    public function edit()
    {
        $id = request()->get('id');
        $post = db()->findOrFail('posts', 'id', $id);

        return view('/posts/edit', ['title' => 'Create post', 'post'=> $post]);
    }

    public function update()
    {
        $id = request()->post('id');
        if (!$id) {
            session()->setFlash('error', 'Not found ID');
            response()->redirect('/');
        }
        $model = new Post();
        $model->loadData();
        $model->attributes['id'] = $id;
        if (!$model->validate()) {
            session()->setFlash('error', $model->listErrors());
            response()->redirect('/posts/edit?id=' . $id);
        }
        var_dump($model->attributes);
    }

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