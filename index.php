<?php

use App\Controllers\AccueilController;
use App\Controllers\AuthentificationController;
use App\Controllers\CompteController;
use App\Controllers\LivreController;
use App\Controllers\MessageController;
use App\Services\Router;

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config/config.php';
require_once 'config/autoload.php';

    
// En fonction des routes utilisées, il est possible d'avoir besoin de la session ; on la démarre dans tous les cas. 
session_start();

$router = new Router();

$router->add('', AccueilController::class, 'accueil');
$router->add('accueil', AccueilController::class, 'accueil');

$router->add('nos-livres', LivreController::class, 'livres');
$router->add('livre/add', LivreController::class, 'ajouter');
$router->add('livre/{id}', LivreController::class, 'livre');
$router->add('livre/{id}/update', LivreController::class, 'modification');
$router->add('livre/{id}/delete', LivreController::class, 'suppression');

$router->add('inscription', AuthentificationController::class, 'inscription');
$router->add('connexion', AuthentificationController::class, 'connexion');
$router->add('deconnexion', AuthentificationController::class, 'logout');


$router->add('compte/{id}', CompteController::class, 'compte');
$router->add('mon-compte', CompteController::class, 'monCompte');

$router->add('messages', MessageController::class, 'message');
$router->add('message/{id}', MessageController::class, 'message');
$router->add('message/{id}/nouveau', MessageController::class, 'nouveau');
$router->add('message/{id}/envoyer', MessageController::class, 'envoyer');


$router->dispatch($_SERVER['REQUEST_URI']);