<?php

namespace Diogof648\SimplePhpRouter;

use JetBrains\PhpStorm\NoReturn;

class Router
{
    private static bool $testing = false;

    /**
     * This method is designed to handle GET requests
     * @param string $route Wanted route (/about for example)
     * @param callable|string $callback
     * @return void
     */
    public static function get(string $route, callable | string $callback): void
    {
        if (self::determineMethod('GET')) {
            self::execute($route, $callback);
        }
    }

    /**
     * This method is designed to handle POST requests
     * @param string $route Wanted route (/about for example)
     * @param callable|string $callback
     * @return void
     */
    public static function post(string $route, callable | string $callback): void
    {
        if (self::determineMethod('POST')) {
            self::execute($route, $callback);
        }
    }

    /**
     * This method is designed to handle PUT requests
     * @param string $route Wanted route (/about for example)
     * @param callable|string $callback
     * @return void
     */
    public static function put(string $route, callable | string $callback): void
    {
        if (self::determineMethod('PUT')) {
            self::execute($route, $callback);
        }
    }

    /**
     * This method is designed to handle DELETE requests
     * @param string $route Wanted route (/about for example)
     * @param callable|string $callback
     * @return void
     */
    public static function delete(string $route, callable | string $callback): void
    {
        if (self::determineMethod('DELETE')) {
            self::execute($route, $callback);
        }
    }

    /**
     * This method is designed to handle PATCH requests
     * @param string $route Wanted route (/about for example)
     * @param callable|string $callback
     * @return void
     */
    public static function patch(string $route, callable | string $callback): void
    {
        if (self::determineMethod('PATCH')) {
            self::execute($route, $callback);
        }
    }

    /**
     * This method is designed to handle undefined requests
     * @param string $route Wanted route (/about for example)
     * @param callable|string $callback
     * @return void
     */
    public static function any(string $route, callable | string $callback): void
    {
        self::execute($route, $callback);
    }

    /**
     * This method is designed to throw a 404 error
     * @param callable|string|null $callback
     * @return void
     */
    #[NoReturn] public static function noMatch(callable | string $callback = null): void
    {
        http_response_code(404);

        if (!is_callable($callback)) {
            self::error(404);
            if (!self::$testing){
                exit();
            }
            return;
        }

        call_user_func($callback);
        if (!self::$testing){
            exit();
        }
    }

    /**
     * This method is designed to execute the request.
     * @param string $route
     * @param callable|string $callback
     * @return void
     */
    private static function execute(string $route, callable | string $callback): void
    {
        if (!is_callable($callback)) {
            self::error(500);
            if (!self::$testing){
                exit();
            }
            return;
        }

        $requestUri = $_SERVER['REQUEST_URI'];
        $requestUri = strtok($requestUri, '?');
        $requestUri = rtrim($requestUri, '/');
        $requestUri = explode('/', $requestUri);

        $route = rtrim($route, '/');
        $route = explode('/', $route);

        array_shift($requestUri);
        array_shift($route);

        // if route is / and request uri is empty too
        if (count($requestUri) === 0 && count($route) === 0) {
            call_user_func($callback);
            if (!self::$testing){
                exit();
            }
            return;
        }

        // if routes doesn't correspond
        if (count($route) != count($requestUri)) {
            return;
        }

        if (count($route) === count($requestUri)) {
            $params = [];

            foreach ($route as $index => $element) {
                if (preg_match('/{(\w)*}/', $element)) {
                    $element = str_replace(['{', '}'], '', $element);
                    $params[$element] = $requestUri[$index];

                    $element = $requestUri[$index];
                }

                // if routes doesn't correspond
                if ($element != $requestUri[$index]) {
                    return;
                }
            }

            call_user_func_array($callback, $params);
            if (!self::$testing){
                exit();
            }
        }
    }

    /**
     * This method is designed to determine which HTTP method has been requested.
     * @param string $method    Wanted method
     * @return bool
     */
    private static function determineMethod(string $method): bool
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'];

        if ($httpMethod === 'POST') {
            if (isset($_POST['_method'])) {
                $httpMethod = $_POST['_method'];
            }
        }

        if ($httpMethod === $method) {
            return true;
        }

        return false;
    }

    /**
     * This method is a pre-made error show
     * @param int $errorCode
     * @return void
     */
    private static function error(int $errorCode): void
    {
        echo "<h1>Error - " . $errorCode . "</h1>";
    }
}