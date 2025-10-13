<?php

namespace core;

use JetBrains\PhpStorm\NoReturn;

class Response
{
    public function setResponseCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect($url = '')
    {
        if ($url) {
            $redirect = $url;
        } else {
            $redirect = $_SERVER['HTTP_REFERER'] ?? base_url();
        }
        header("Location: {$redirect}");
        die;
    }
}