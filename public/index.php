<?php

use Controller\FrontController;
use App\{Request, Session, Router};

// charger autoloader
require '../vendor/autoload.php';
Session::start();
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();
$action = Request::get('action');
/*TO DO - FINIR LE ROUTEUR
$router = new Router($action);
$router->get('', [FrontController::class, 'home']);

$router->run();
exit;
*/

if ($action === '') {
    $controller = new FrontController();
    $controller->home();
} elseif ($action === 'posts') {
    $controller = new FrontController();
    $controller->posts();
} elseif ($action === 'connexion') {
    $controller = new FrontController();
    $controller->connexion();
} elseif ($action === 'curriculum') {
    $controller = new FrontController();
    $controller->curriculum();
} elseif ($action === 'admin') {
    $controller = new FrontController();
    $controller->admin();
} else {
    echo 'PageInconnue';
}

/*
// ****************** COPIE TP_BLOG

if (isset($_GET['action']))
{
    if($action === '') {
        $controller = new FrontController();
        $controller->index();
    }
    if ($_GET['action'] == 'listPosts')
    {
        listPosts();
    }
    elseif ($_GET['action'] == 'post')
    {
        if (isset($_GET['id']) && $_GET['id'] > 0)
        {
            post();
        }
        else
        {
            echo 'Erreur : aucun identifiant de billet envoyé';
        }
    }
    elseif ($_GET['action'] == 'addComment')
    {
        if (isset($_GET['id']) && $_GET['id'] > 0)
        {
            if (!empty($_POST['author']) && !empty($_POST['comment']))
            {
                addComment($_GET['id'], $_POST['author'], $_POST['comment']);
            }
            else
            {
                echo 'Erreur : tous les champs ne sont pas remplis !';
            }
        }
    }
}
else
{
    listPosts();
}




// Appel routeur => lui passer l'action

//$router->get('index', ['controller'=>'FrontController', 'method'=>'index']);


// Lancer le routeur
*/
