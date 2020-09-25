<?php

session_start();

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__,1));
$dotenv->load();

// charger autoloader
require '../vendor/autoload.php';




$action = $_GET['action'] ?? '';


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

// *******************  FIN







// Appel routeur => lui passer l'action

$router->get('index', ['controller'=>'FrontController', 'method'=>'index']);


// Lancer le routeur