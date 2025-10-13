<?php

namespace core;

abstract class Controller
{
    public function render(string $view, array $data = [], $layout = ''): string
    {
        return app()->view->render($view, $data, $layout);
    }
}