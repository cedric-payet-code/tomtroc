<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config/config.php';
require_once 'config/autoload.php';

$router = new Router();

$router->add('', 'AccueilController', 'index');
$router->add('accueil', 'AccueilController', 'index');
$router->add('nos-livres', 'NosLivresController', 'index');
$router->add('livre/{id}', 'LivreController', 'index');

$router->dispatch($_SERVER['REQUEST_URI']);