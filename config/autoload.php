<?php

/**
 * Système d'autoload conforme PSR-4.
 * Le namespace racine "App\" correspond à la racine du projet :
 * App\Controllers\LivreController => Controllers/LivreController.php
 */
spl_autoload_register(function ($className) {
    $prefix = 'App\\';
    $baseDir = dirname(__DIR__) . '/';

    // La classe n'appartient pas au namespace App : on laisse la main aux autres autoloaders.
    if (strncmp($className, $prefix, strlen($prefix)) !== 0) {
        return;
    }

    // Retire le préfixe et transforme les "\" du namespace en "/" de chemin.
    $relativeClass = substr($className, strlen($prefix));
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});
