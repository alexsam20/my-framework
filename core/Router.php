<?php

namespace core;

class Router
{
    protected array $routes = [];
    public array $routeParams = [];

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
        $callback = $this->matchRoute($method, $path);
//        $callback = $this->routes[$method]["/$path"] ?? false;

        if (false === $callback) {
            abort();
        }

        if (is_array($callback)) {
            $callback[0] = new $callback[0]();
        }

        return call_user_func($callback);
    }

    private function matchRoute($method, $path)
    {
        foreach ($this->routes[$method] as $pattern => $route) {
            if (preg_match("#^{$pattern}$#", "/{$path}", $matches)) {
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $this->routeParams[$k] = $v;
                    }
                }

                return $route;
            }
        }

        return false;
    }
}