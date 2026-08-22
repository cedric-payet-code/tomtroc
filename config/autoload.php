<?php

/**
 * Système d'autoload.
 */
spl_autoload_register(function($className) {

    // Services
    if (file_exists('services/' . $className . '.php')) {
        require_once 'services/' . $className . '.php';
    }

    // Models
    if (file_exists('models/' . $className . '.php')) {
        require_once 'models/' . $className . '.php';
    }

    // Managers
    if (file_exists('managers/' . $className . '.php')) {
        require_once 'managers/' . $className . '.php';
    }

    // Controllers
    if (file_exists('controllers/' . $className . '.php')) {
        require_once 'controllers/' . $className . '.php';
    }

    // Views
    if (file_exists('views/' . $className . '.php')) {
        require_once 'views/' . $className . '.php';
    }
});