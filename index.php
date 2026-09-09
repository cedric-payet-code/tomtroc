<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config/config.php';
require_once 'config/autoload.php';

    
// En fonction des routes utilisées, il est possible d'avoir besoin de la session ; on la démarre dans tous les cas. 
session_start();

$router = new Router();

$router->add('', 'AccueilController', 'accueil');
$router->add('accueil', 'AccueilController', 'accueil');

$router->add('nos-livres', 'LivreController', 'livres');
$router->add('livre/{id}', 'LivreController', 'livre');
$router->add('livre/{id}/update', 'LivreController', 'modification');
$router->add('livre/{id}/delete', 'LivreController', 'suppression');

$router->add('inscription', 'AuthentificationController', 'inscription');
$router->add('connexion', 'AuthentificationController', 'connexion');
$router->add('deconnexion', 'AuthentificationController', 'logout');


$router->add('compte/{id}', 'CompteController', 'compte');
$router->add('mon-compte', 'CompteController', 'monCompte');

$router->add('message', 'MessageController', 'message');
$router->add('message/{id}', 'MessageController', 'message');
$router->add('message/{id}/nouveau', 'MessageController', 'nouveau');


$router->dispatch($_SERVER['REQUEST_URI']);