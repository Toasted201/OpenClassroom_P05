<?php

namespace Controller;

use Manager\PostManager;

class FrontController extends BaseController
{
    public function home()
    {

        $manager = new PostManager();
        $postsHome=$manager->getPostsHome();
        echo $this->render('home.html.twig',['listPostsHome'=>$postsHome]);
    }

    public function posts()
    {
        $manager = new PostManager();
        $posts=$manager->getPosts();
        echo $this->render('posts.html.twig',['listPosts'=>$posts]);
    }

    public function connexion()
    {
        echo $this->render('connexion.html.twig',[]);
    }

    public function curriculum()
    {
        echo $this->render('cv.html.twig',[]);
    }

    public function admin()
    {
        echo $this->render('admin.html.twig',[]);
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