<?php

namespace core;

class Application
{
    public string $uri = '';

    public Request $request;

    public Response $response;

    public Router $router;

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->request = new Request($this->uri);
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }
}