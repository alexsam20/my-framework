<?php

use JetBrains\PhpStorm\NoReturn;

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

function response(): \core\Response
{
    return app()->response;
}

function base_url(string $path = ''): string
{
    return URL_ROOT . $path;
}

function hsc($str): string
{
    return htmlspecialchars($str, ENT_QUOTES);
}

function old($field_name): string
{
    return isset($_POST[$field_name]) ? hsc($_POST[$field_name]) : '';
}

function get_errors($field_name, $errors = []): string
{
    $output = '';
    if (isset($errors[$field_name])) {
        $output .= '<div class="invalid-feedback d-block"><ul class="list-unstyled">';
        foreach ($errors[$field_name] as $error) {
            $output .= "<li>{$error}</li>";
        }
        $output .= '</ul></div>';
    }
    return $output;
}

function get_validation_class($field_name, $errors = []): string
{
    if (empty($errors)) {
        return '';
    }
    return isset($errors[$field_name]) ? 'is-invalid' : 'is-valid';
}

#[NoReturn] function abort(string $error = '', int $code = 404): void
{
    response()->setResponseCode($code);
    if (DEBUG || $code === 404) {
        echo view("errors" . DS . $code, ['error' => $error], false);
    }
    die;
}

function db(): \core\Database
{
    return app()->db;
}

function session(): \core\Session
{
    return app()->session;
}

function router(): \core\Router
{
    return app()->router;
}

function get_alerts(): void
{
    if (!empty($_SESSION['flash_message'])) {
        foreach ($_SESSION['flash_message'] as $key => $value)  {
            view()->renderPartial("inc/alert_{$key}", ["flash_{$key}" => session()->getFlash($key)]);
        }
    }
}
