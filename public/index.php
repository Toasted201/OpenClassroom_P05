<?php

use Controller\FrontController;
use App\{Request, Session, Router};

// charger autoloader
require '../vendor/autoload.php';
Session::start();
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

$router = new Router();
$router->pushGet('', [FrontController::class, 'home']);
$router->pushGet('posts', [FrontController::class, 'posts']);
$router->pushGet('post', [FrontController::class, 'post', ['postId']]);
$router->pushGet('connexion', [FrontController::class, 'connexion']);
$router->pushGet('curriculum', [FrontController::class, 'curriculum']);
$router->pushGet('admin', [FrontController::class, 'admin']);
$router->pushPost('contact', [FrontController::class, 'contact']);
$router->run();
exit;
