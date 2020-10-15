<?php

namespace Controller;

use Manager\PostManager;
use App\Session;
use App\Request;
use Manager\UserManager;
use Model\Entity\User;

class FrontController extends BaseController
{
    public function home()
    {
        $manager = new PostManager();
        $postsHome = $manager->getPostsHome();
        $successContact = Session::Flash('successContact');
        $errorContact = Session::Flash('errorContact');
        $connectedUser = $this->getConnectedUser();
        $firstName = null;
        if (!empty($connectedUser)) {
            $firstName = $connectedUser->firstName();
        }
        echo $this->render(
            'Front/home.html.twig',
            ['listPostsHome' => $postsHome,
            'flashError' => $errorContact,
            'flashSuccess' => $successContact,
            'firstName' => $firstName]
        );
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

    public function authentification()
    {
        
        $errorConnexion = Session::Flash('errorConnexion');
        echo $this->render(
            'Front/authentification.html.twig',
            ['flashError' => $errorConnexion]
        );
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
        if (!empty($_POST['identity']) & !empty($_POST['email']) & !empty($_POST['message'])) {
        // Create the Transport
            $transport = (new \Swift_SmtpTransport('in-v3.mailjet.com', 587))
            ->setUsername($_ENV['SMTP_USERNAME'])
            ->setPassword($_ENV['SMTP_PASSWORD'])
            ;

        // Create the Mailer using your created Transport
            $mailer = new \Swift_Mailer($transport);

        // Create a message
            $body = 'Nom : ' . $_POST['identity'] .
            PHP_EOL . 'Email : ' . $_POST['email'] .
            PHP_EOL . 'Message : ' . $_POST['message'];
            $message = (new \Swift_Message('Contact Helixsi.com'))
            ->setFrom(['julie@helixsi.com' => 'Julie Xaxa'])
            ->setTo(['julie@helixsi.com' => 'Julie Xaxa'])
            ->setBody($body)
            ->setSubject('Formulaire Contact HelixSI')
            ;

        // Send the message
            $result = $mailer->send($message);
            Session::setFlash('successContact', 'Votre message a été envoyé');
            $this->home();
        } else {
            Session::setFlash('errorContact', 'Votre message n\'a pas pu être envoyé');
            $this->home();
        }
    }
    //TO DO utiliser error ++ , avec un si error >0 alors //

    public function connexion()
    {
        $mail = Request::postData('mailConnect');
        $pass = Request::postData('passConnect');
        $userManager = new UserManager();
        $user = $userManager->getByMail($mail);
        if ($user === null) {
            Session::setFlash('errorConnexion', 'Le mail n\'existe pas');
            $this->authentification();
        } else {
            $isPasswordCorrect = password_verify($pass, $user->pass());
            if (!$isPasswordCorrect) {
                Session::setFlash('errorConnexion', 'Le mot de passe est incorrect ');
                $this->authentification();
            } else {
                Session::set('connectedUser', serialize($user));
                $this->home();
            }
        }
    }
}
