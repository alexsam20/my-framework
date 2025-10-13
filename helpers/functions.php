<?php

function print_pre($var, $exit = false): void
{
    echo '<pre>' . print_r($var, 1) . '</pre>';
    if ($exit) {
        die();
    }
}
function app(): \core\Application
{
    return \core\Application::$app;
}

function view(string $view = '', array $data = [], $layout = ''): false|string|\core\View
{
    if ($view) {
        return app()->view->render($view, $data, $layout);
    }

    return app()->view;
}

function request(): \core\Request
{
    return app()->request;
}

function baseUrl(string $path = ''): string
{
    return URL_ROOT . $path;
}
