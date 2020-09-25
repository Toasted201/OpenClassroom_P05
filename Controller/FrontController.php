<?php

namespace Controller;

class FrontController{
    public function home(){
        require 'view\home.php';
        echo 'frontcontroller';
    }
}


/* **** Copie TP_Blog *******


require('model/frontend.php');

function listPosts()
{
    $posts = getPosts();
    $isLoggedIn = isLoggedIn();

    require('views/frontend/listPostsView.php');
}

function post()
{
    if (isset($_GET['id']) && $_GET['id'] > 0) 
    {
        $post = getPost($_GET['id']);
        $comments = getComments($_GET['id']);
        require('views/frontend/postView.php');
    }
    else 
    {
        echo 'Erreur : aucun identifiant de billet envoyé';
    }
}

function addComment($post_id, $author, $comment)
{
    $affectedLines = postComment($post_id, $author, $comment);

    if ($affectedLines === false) {
        die('Impossible d\'ajouter le commentaire !');
    }
    else {
        header('Location: index.php?action=post&id=' . $post_id);
    }
}
*/