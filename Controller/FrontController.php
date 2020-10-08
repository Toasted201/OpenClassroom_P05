<?php

namespace Controller;

use Manager\PostManager;
use App\Session;

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

    public function contact()
    {
        // Create the Transport
        $transport = (new \Swift_SmtpTransport('in-v3.mailjet.com', 587))
        ->setUsername($_ENV['SMTP_USERNAME'])
        ->setPassword($_ENV['SMTP_PASSWORD'])
        ;

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        // Create a message
        $message = (new \Swift_Message('Contact Helixsi.com'))
        ->setFrom(['julie@helixsi.com' => 'Julie Xaxa'])
        ->setTo(['julie@helixsi.com' => 'Julie Xaxa'])
        ->setBody('Here is the message itself')
        ->setSubject('Formulaire HelixSI')
        ;

        // Send the message
        $result = $mailer->send($message);
        $this->home();
    }
    /* préparation fonction pour envoi de mail -
    Vérif données avec if et fonction mail de php ou librairy 'php swift mailer' ou 'php mailer'
    utiliser error ++ , avec un si error >0 alors

    public function contact() {

    } */
}
