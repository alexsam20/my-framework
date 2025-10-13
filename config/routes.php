<?php

/** @var \core\Application $app */

$app->router->get('/', function () {
    return view('main', ['title' => 'Home Page'], 'default');
});

$app->router->get('/about', function () {
    return view('about');
});

$app->router->get('/contact', [\app\Controllers\ContactController::class, 'index']);

$app->router->post('/contact', [\app\Controllers\ContactController::class, 'send']);
