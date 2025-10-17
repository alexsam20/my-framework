<?php

/** @var \core\Application $app */

$app->router->get('/', [\app\Controllers\HomeController::class,'index']);

$app->router->get('/about', function () {
    return view('about');
});

$app->router->get('/contact', [\app\Controllers\ContactController::class, 'index']);
$app->router->post('/contact', [\app\Controllers\ContactController::class, 'send']);

$app->router->get('/posts/create', [\app\Controllers\PostController::class, 'create']);
$app->router->post('/posts/store', [\app\Controllers\PostController::class, 'store']);
$app->router->get('/posts/edit', [\app\Controllers\PostController::class, 'edit']);
$app->router->post('/posts/update', [\app\Controllers\PostController::class, 'update']);
$app->router->get('/posts/delete', [\app\Controllers\PostController::class, 'delete']);

