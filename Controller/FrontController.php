<?php

namespace Controller;

use Manager\PostManager;

class FrontController extends BaseController
{
    public function home()
    {

        $manager = new PostManager();
        $postsHome = $manager->getPostsHome();
        echo $this->render('Front/home.html.twig', ['listPostsHome' => $postsHome]);
    }

    public function posts()
    {
        $manager = new PostManager();
        $posts = $manager->getPosts();
        echo $this->render('Front/posts.html.twig', ['listPosts' => $posts]);
    }

    
    public function post($postId)
    {
        $manager = new PostManager();
        $post = $manager->getPost($postId);
        echo $this->render('Front/post.html.twig', ['post' => $post]);
    }

    public function connexion()
    {
        echo $this->render('Front/connexion.html.twig', []);
    }

    public function curriculum()
    {
        echo $this->render('Front/cv.html.twig', []);
    }

    public function admin()
    {
        echo $this->render('Admin/admin.html.twig', []);
    }

    /* préparation fonction pour envoi de mail - 
    Vérif données avec if et fonction mail de php ou librairy 'php swift mailer' ou 'php mailer'
    
    public function contact() {

    } */
}
