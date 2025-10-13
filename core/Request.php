<?php

namespace core;

class Request
{
    public string $uri;

    public function __construct(string $uri)
    {
        $this->uri = trim(urldecode($uri), '/');
    }

    public function getPath(): string
    {
        return $this->removeQueryString();
    }

    public function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function isGet(): bool
    {
        return $this->getMethod() === 'GET';
    }

    public function isPost(): bool
    {
        return $this->getMethod() === 'POST';
    }

    public function get(string $key, $default = null): ?string
    {
        return $_GET[$key] ?? $default;
    }

    public function post(string $key, $default = null): ?string
    {
        return $_POST[$key] ?? $default;
    }

    public function removeQueryString(): string
    {
        if ($this->uri) {
            $params = explode('?', $this->uri);
            if (false === str_contains($params[0], '=' )) {
                return trim($params[0], '/');
            }
        }

        return '';
    }

    public function getData(): array
    {
        $data = [];
        $requestData = $this->isGet() ? $_GET : $_POST;
        foreach ($requestData as $key => $value) {
            $data[$key] = trim($value);
        }

        return $data;
    }
}