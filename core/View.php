<?php

namespace core;

class View
{
    public string $content = '';

    public function __construct(public $layout = ''){}

    public function render(string $view, array $data = [], $layout = ''): false|string
    {
        extract($data);
        $viewFile = VIEWS . DS . $view . '.php';
        if(file_exists($viewFile)){
            ob_start();
            require_once $viewFile;
            $this->content = ob_get_clean();
        } else {
            abort("Not found view $viewFile", 500);
            /*app()->response->setResponseCode(500);
            return view('errors/500', ['error' => "Not found view $viewFile"], false);*/
        }

        if (false === $layout) {
            return $this->content;
        }

        $layoutFileName = $layout ?: $this->layout;
        $layoutFile = VIEWS . DS . 'layouts' . DS . $layoutFileName . '.php';
        if(file_exists($layoutFile)){
            ob_start();
            require_once $layoutFile;
            return ob_get_clean();
        }

        abort("Not found layout $layoutFile", 500);

        return '';
    }

    public function renderPartial(string $view, array $data = []): void
    {
        extract($data);
        $view_file = VIEWS . DS . $view . '.php';
        if (is_file($view_file)) {
            require $view_file;
        } else {
            echo "File {$view_file} not found";
        }
    }
}