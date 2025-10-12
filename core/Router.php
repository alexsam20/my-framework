<?php

namespace core;

class Router
{
    /*public Request $request;
    public Response $response;*/
    protected array $routes = [];

    public function __construct(public Request $request, public Response $response)
    {}

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function get($path, $callback = null): void
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback = null): void
    {
        $this->routes['POST'][$path] = $callback;
    }
}