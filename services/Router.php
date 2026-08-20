<?php

class Router
{
    private array $routes = [];

    public function add(string $uri, string $controller, string $method): void
    {
        $uri = trim($uri, '/');
        $pattern = preg_replace('#\{[a-zA-Z_]+\}#', '([^/]+)', $uri);
        $pattern = '#^' . $pattern . '$#';

        $this->routes[] = [
            'pattern' => $pattern,
            'controller' => $controller,
            'method' => $method,
        ];
    }

    public function dispatch(string $uri): void
    {
        $basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $path = parse_url($uri, PHP_URL_PATH);

        if ($basePath !== '/' && str_starts_with($path, $basePath)) {
            $path = substr($path, strlen($basePath));
        }

        $path = trim($path, '/');

        foreach ($this->routes as $route) {
            if (preg_match($route['pattern'], $path, $matches)) {
                array_shift($matches);

                $controllerClass = $route['controller'];
                $method = $route['method'];
                $controller = new $controllerClass();
                $controller->$method(...$matches);
                return;
            }
        }

        http_response_code(404);
        echo "Page introuvable.";
    }
}