<?php

/** @var \core\Application $app */

$app->router->get('/', function () {
    return 'Main Page';
});

$app->router->get('/about', function () {
    return 'About Page';
});

$app->router->get('/contact', [\app\Controllers\ContactController::class, 'index']);

$app->router->post('/contact', [\app\Controllers\ContactController::class, 'send']);
