<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config/config.php';
require_once 'config/autoload.php';

$router = new Router();

$router->add('', 'AccueilController', 'index');
$router->add('home', 'AccueilController', 'index');
// $router->add('livre/{id}', 'BookController', 'show');

$router->dispatch($_SERVER['REQUEST_URI']);