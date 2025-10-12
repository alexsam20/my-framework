<?php

/** @var \core\Application $app */

$app->router->get('/', function () {
    return 'Main Page';
});

$app->router->get('/about', function () {
    return 'About Page';
});

$app->router->get('/contact', function () {
    return 'Contact form GET Page';
});

$app->router->post('/contact', function () {
    return 'Contact form POST Page';
});
