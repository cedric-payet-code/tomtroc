<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config/config.php';
require_once 'config/autoload.php';

    
// En fonction des routes utilisées, il est possible d'avoir besoin de la session ; on la démarre dans tous les cas. 
session_start();

$router = new Router();

$router->add('', 'AccueilController', 'index');
$router->add('accueil', 'AccueilController', 'index');
$router->add('nos-livres', 'NosLivresController', 'index');
$router->add('livre/{id}', 'LivreController', 'index');
$router->add('livre/{id}/update', 'LivreController', 'update');
$router->add('livre/{id}/delete', 'LivreController', 'delete');
$router->add('inscription', 'InscriptionController', 'index');
$router->add('connexion', 'ConnexionController', 'index');
$router->add('deconnexion', 'ConnexionController', 'logout');
$router->add('mon-compte', 'MonCompteController', 'index');


$router->dispatch($_SERVER['REQUEST_URI']);