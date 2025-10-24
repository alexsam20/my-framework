<?php

namespace app\Controllers;

use app\Models\Post;

class PostController extends BaseController
{
    public function show()
    {
        $slug = router()->routeParams['slug'] ?? '';
        $post = db()->selectWhere('posts', ['slug'=> $slug]);
        if (!$post) {
            abort();
        }

        return view('posts/show', ['title' => $post['title'], 'post'=> $post]);
    }

    public function edit(): false|string|\core\View
    {
        $id = request()->get('id');
        $post = db()->findOrFail('posts', 'id', $id);

        return view('/posts/edit', ['title' => 'Create post', 'post'=> $post]);
    }

    public function update(): void
    {
        $id = request()->post('id');
        if (!$id) {
            session()->setFlash('error', 'Not found Post');
            response()->redirect('/');
        }
        $model = new Post();
        $model->loadData();
        $model->attributes['id'] = $id;
        if (!$model->validate()) {
            session()->setFlash('error', $model->listErrors());
            response()->redirect('/posts/edit?id=' . $id);
        }
        if (false !== db()->update('posts', $model->attributes, 'id')) {
            session()->setFlash('success', "Post {$id} saved");
            response()->redirect('/posts/edit?id=' . $id);
        }

        session()->setFlash('error', 'Error updating');
        response()->redirect('/');
    }

    public function create(): false|string|\core\View
    {
        return view('/posts/create', ['title' => 'Create post']);
    }

    public function store(): bool|string|\core\View
    {
        if (request()->isPost()) {
            $model = new Post();
            $model->loadData();

            if (isset($_FILES['thumbnail'])) {
                $model->attributes['thumbnail'] = $_FILES['thumbnail'];
            } else {
                $model->attributes['thumbnail'] = [];
            }

            if (isset($_FILES['thumbnails'])) {
                $model->attributes['thumbnails'] = $_FILES['thumbnails'];
            } else {
                $model->attributes['thumbnails'] = [];
            }

            print_pre($model->attributes);
            if (!$model->validate()) {
                print_pre($model->getErrors()); die;
                return view('/posts/create', ['title' => 'Create post', 'errors' => $model->getErrors()]);
            }

            if ($id = $model->savePost()) {
                session()->setFlash('success', "Post $id created");
            } else {
                session()->setFlash('error', 'Unknown errors');
            }
            response()->redirect('/posts/create');
        }

        response()->redirect('/posts/create');
        return true;
    }

    public function delete(): bool
    {
        (int)$id = request()->get('id');
        if (!$id) {
            session()->setFlash('error', 'Not found ID');
            response()->redirect('/');
        }
        if (db()->delete('posts', $id)) {
            session()->setFlash('success', "Post $id soft deleted");
            response()->redirect('/', );
            return true;
        }

        session()->setFlash('error', 'Post not deleted');
        response()->redirect('/', );
        return false;
    }
}