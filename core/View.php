<?php

namespace core;

class View
{
    public string $content = '';

    public function __construct(public string $layout = ''){}

    public function render(string $view, array $data = [], string $layout = ''): false|string
    {
        extract($data);
        $viewFile = VIEWS . DS . $view . '.php';
        if(file_exists($viewFile)){
            ob_start();
            require_once $viewFile;

            return ob_get_clean();
        }
        app()->response->setResponseCode(500);

        return view('errors/500');
    }
}