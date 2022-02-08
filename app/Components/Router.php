<?php

namespace Components;

use Exception;
use ReflectionClass;
use Components\Http\Response;
use Controllers;

class Router
{

    private array $routes;
    private $response;

    public function __construct()
    {
        $routesPath = './routes.php';
        $this->routes = include($routesPath);
        $this->response = new Response();

    }

    private function getUri(): string
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            $uri = '/' . trim($_SERVER['REQUEST_URI'], '/');
        }
        return $uri;
    }

    /**
     * @throws \ReflectionException
     * @throws Exception
     */
    public function run(): void
    {
        $uri = $this->getUri();

        if (!(is_array($this->routes) && count($this->routes))) {
            $this->response->response('Route does not exist', 404);
        }

        foreach ($this->routes as $uriPattern => $value) {
            if (!preg_match("~$uriPattern~", $uri)) {
                continue;
            }

            $segments = explode('@', $value['action']);

            $method = $value['method'];
            $parameter = $value['parameters'];
            list($controller, $action) = $segments;

            $controllerClass = 'Controllers\\' . $controller;

            if (!in_array($_SERVER['REQUEST_METHOD'], $method)) {
                $this->response->response('Method Not Allowed', 405);
            }

            $controllerObject = new $controllerClass();

            $reflector = new ReflectionClass($controllerObject);
            $funcArguments = $reflector->getMethod($action)->getParameters();
            $valueParams = [];

            if ($funcArguments) {
                $valueParams = $this->getParameters($funcArguments, $parameter);
            }

            $result = call_user_func_array(array($controllerObject, $action), $valueParams);

            $this->response->response($result, 200);
        }

        $this->response->response('Not Found', 404);

    }

    /**
     * @throws Exception
     */
    public function getParameters($funcArguments, $parameters): array
    {
        $res = [];
        $args = [];
        foreach ($funcArguments as $value) {
            $args[] = $value->name;
        }
        foreach ($parameters as $value) {
            if (!in_array($value, $args)) {
                $this->response->response('Not allowed argument', 405);
            }
            if (is_null($_GET[$value])) {
                $this->response->response('Not allowed argument', 405);
            }
            $res[] = $_GET[$value];
        }

        return $res;
    }

}
