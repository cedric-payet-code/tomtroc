<?php

namespace App\Services;

use App\Controllers\Erreur404Controller;

class Router
{
    private array $routes = [];

    // Ajoute une route au routeur.
    public function add(string $uri, string $controller, string $method): void
    {
        // Retire les "/" au début et à la fin de l'URI.
        $uri = trim($uri, '/');

        // Transforme {parametre} en expression régulière.
        $pattern = preg_replace('#\{[a-zA-Z_]+\}#', '([^/]+)', $uri);
        $pattern = '#^' . $pattern . '$#';

        $this->routes[] = [
            'pattern' => $pattern,
            'controller' => $controller,
            'method' => $method,
        ];
    }

    // Cherche une route correspondant à l'URI demandée.
    public function dispatch(string $uri): void
    {
        // Récupère le dossier dans lequel se trouve le script PHP.
        $basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));

        // Ne conserve que le chemin de l'URL, sans les éventuels paramètres GET.
        $path = parse_url($uri, PHP_URL_PATH);

        // Retire le chemin de base pour obtenir uniquement la route.
        if ($basePath !== '/' && str_starts_with($path, $basePath)) {
            $path = substr($path, strlen($basePath));
        }

        $path = trim($path, '/');

        foreach ($this->routes as $route) {
            // Vérifie si l'URL correspond à la route.
            if (preg_match($route['pattern'], $path, $matches)) {
                // Retire la correspondance complète et conserve les paramètres.
                array_shift($matches);

                $controllerClass = $route['controller'];
                $method = $route['method'];

                // Instancie le contrôleur et appelle sa méthode.
                $controller = new $controllerClass();
                $controller->$method(...$matches);
                return;
            }
        }

        $controller = new Erreur404Controller();
        $controller->show();
    }
}