<?php

function app(): \core\Application
{
    return \core\Application::$app;
}

function view(string $view = '', array $data = [], string $layout = ''): false|string|\core\View
{
    if ($view) {
        return app()->view->render($view, $data, $layout);
    }

    return app()->view;
}
