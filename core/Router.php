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
        $path = trim($path, "/");
        $this->routes['GET']["/$path"] = $callback;
    }

    public function post($path, $callback = null): void
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method]["/$path"] ?? false;

        if (false === $callback) {
            $this->response->setResponseCode(404);
            return 'Page not found';
        }

        if (is_array($callback)) {
            /*$class = new $callback[0]();
            $action = $callback[1];

            return $class->$action();*/
            $callback[0] = new $callback[0]();
        }

        return call_user_func($callback);
    }
}