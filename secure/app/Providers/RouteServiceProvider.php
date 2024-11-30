<?php

namespace app\Providers;

use app\Http\Errors\ErrorHandler;

class RouteServiceProvider
{
    protected array $routes = [];

    /**
     * Loads routes from the specified file.
     *
     * @param string $file The path to the file containing routes.
     *
     * @return int Returns the HTTP status code. 200 if routes are loaded successfully,
     *             or 500 if the file does not exist.
     */
    public function loadRoutes(string $file): int
    {
        if (!file_exists($file)) {
            return 500;
        }

        $routes = require $file;
        $this->routes = $routes;
        return 200;
    }

    /**
     * Resolves the incoming request and executes the corresponding controller method.
     *
     * @return int Returns the HTTP status code. Returns 200 if the request is
     *                 successfully handled, or 404 if no matching route is found.
     *                 Possible error codes: 404 if no matching route is found, 500 if
     *                 there's an internal server error.
     */
    public function resolveRequest(): int
    {
        $url = $_SERVER["REQUEST_URI"];
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if (APP_ENV === "development") {
            $url = str_replace("/" . $_ENV["APP_NAME"] . "/public", "", $url);
        }

        $routeData = $this->findMatchingRoute($url, $requestMethod);
        if ($routeData === null) {
            return 404;
        }

        $controllerMethod = $routeData["method"] ?? null;
        $controllerAction = $routeData["action"] ?? null;
        if (!$controllerMethod || !$controllerAction) {
            return 500;
        }

        $middleware = $routeData["middleware"] ?? null;
        if ($middleware) {
            $middleware = "app\Http\Middleware\\$middleware";
        }

        if ($middleware && class_exists($middleware)) {
            $middlewareInstance = new $middleware();
            $errorCode = $middlewareInstance->handle();
            if ($errorCode && is_int($errorCode) && $errorCode !== 200) {
                return $errorCode;
            }
        }

        [$controller, $method] = explode("@", $controllerAction);
        $controller = "app\Http\Controllers\\$controller";

        if (!class_exists($controller) || !method_exists($controller, $method)) {
            return 500;
        }

        $controllerInstance = new $controller();
        $errorCode = $controllerInstance->$method($routeData["parameters"]);
        if ($errorCode && is_int($errorCode) && $errorCode !== 200) {
            return $errorCode;
        }

        return 200;
    }

    /**
     * Check for errors and handle them if they occur.
     *
     * @param int $error The error code to check for.
     *
     * @return void
     */
    public function checkForErrors(int $error): void
    {
        if ($error === 200) {
            return;
        }

        $errorHandler = new ErrorHandler();
        $errorHandler->handle($error);
    }

    /**
     * Find the matching route for the given URL and request method.
     *
     * @param string $url The URL to match against the registered routes.
     * @param string $method The HTTP request method (e.g., GET, POST, etc.).
     *
     * @return array|null Returns an associative array representing the matched route
     *                   and its details. Returns null if no matching route is found.
     *                   The array may contain the following keys:
     *                   - "method": The HTTP request method allowed for the route.
     *                   - "action": The controller action to be executed.
     *                   - "middleware": Optional middleware name for the route.
     *                   - "parameters": An array of parameters extracted from the URL.
     */
    private function findMatchingRoute(string $url, string $method): ?array
    {
        $longestMatch = null;
        $longestMatchLength = 0;

        foreach ($this->routes as $route => $details) {
            if ($route === "/" && $url !== "/") {
                continue;
            }

            if (($details["method"] === $method || $details["method"] === "*") && str_starts_with($url, $route)) {
                $routeLength = strlen($route);

                if ($routeLength > $longestMatchLength) {
                    $extraSegments = substr($url, $routeLength);
                    $extraSegments = trim($extraSegments, "/");
                    $parameters = $extraSegments === "" ? [] : explode("/", $extraSegments);

                    $details["parameters"] = $parameters;
                    $longestMatch = $details;
                    $longestMatchLength = $routeLength;
                }
            }
        }

        if ($longestMatch === null && str_starts_with($url, "/?")) {
            return [
                'method' => $method,
                'action' => 'HomeController@index',
                'parameters' => [],
            ];
        }

        return $longestMatch;
    }
}