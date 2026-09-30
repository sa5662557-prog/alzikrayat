<?php

/**
 * Manual Router responsible for registering routes and
 * dispatching HTTP requests to the correct controller action.
 */
class Router
{
    /**
     * Stores all registered application routes.
     *
     * @var array
     */
    private $routes = [];

    /**
     * Registers a new route with its HTTP method, URL pattern,
     * and controller action.
     *
     * @param string $method HTTP request method such as GET or POST.
     * @param string $routePath URL path pattern such as /photo/{id}.
     * @param array $controllerAction Controller class and method.
     * @return void
     * @throws InvalidArgumentException If the controller action is invalid.
     */
    public function add($method, $routePath, $controllerAction)
    {
        if (!is_array($controllerAction) || count($controllerAction) !== 2) {
            throw new InvalidArgumentException(
                'Controller action must contain a class and method.'
            );
        }

        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $routePath,
            'action' => $controllerAction
        ];
    }

    /**
     * Matches the current request against registered routes
     * and executes the matching controller action.
     *
     * @param string $requestMethod HTTP request method.
     * @param string $requestPath Requested URL path.
     * @return void
     * @throws Exception If no matching route is found.
     */
    public function dispatch($requestMethod, $requestPath)
    {
        foreach ($this->routes as $route) {

            if ($route['method'] !== strtoupper($requestMethod)) {
                continue;
            }

            $pattern = preg_replace(
                '/\{([a-zA-Z]+)\}/',
                '([^/]+)',
                $route['path']
            );

            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $requestPath, $matches)) {

                array_shift($matches);

                $controllerClass = $route['action'][0];
                $controllerMethod = $route['action'][1];

                if (!class_exists($controllerClass)) {
                    throw new Exception(
                        "Controller class not found: " . $controllerClass
                    );
                }

                $controller = new $controllerClass();

                if (!method_exists($controller, $controllerMethod)) {
                    throw new Exception(
                        "Controller method not found: " . $controllerMethod
                    );
                }

                call_user_func_array(
                    [$controller, $controllerMethod],
                    $matches
                );

                return;
            }
        }

        http_response_code(404);
        echo "404 - Page Not Found";
    }
}