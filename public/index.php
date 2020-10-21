<?php

use Controller\FrontController;
use Controller\BackController;
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
$router->pushPost('addComment', [FrontController::class, 'addComment']);
$router->pushGet('authentification', [FrontController::class, 'authentification']);
$router->pushGet('deconnexion', [FrontController::class, 'deconnexion']);
$router->pushPost('inscription', [FrontController::class, 'inscription']);
$router->pushPost('connexion', [FrontController::class, 'connexion']);
$router->pushGet('curriculum', [FrontController::class, 'curriculum']);
$router->pushPost('contact', [FrontController::class, 'contact']);
$router->pushGet('admin', [BackController::class, 'admin']);
$router->pushPost('addPost', [BackController::class, 'addPost']);
$router->pushGet('newPost', [BackController::class, 'newPost']);
$router->pushGet('editPostList', [BackController::class, 'editPostList']);
$router->pushGet('editPostDetail', [BackController::class, 'editPostDetail', ['postId']]);
$router->pushPost('updatePost', [BackController::class, 'updatePost']);
$router->pushGet('validComment', [BackController::class, 'validComment']);
$router->run();
exit;
