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
        echo $this->render(
            'Front/home.html.twig',
            ['listPostsHome' => $postsHome,
            'flashError' => $errorContact,
            'flashSuccess' => $successContact]
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
        $errorInscription = Session::Flash('errorInscription');
        echo $this->render(
            'Front/authentification.html.twig',
            ['flashError' => $errorConnexion,
            'flashErrorInscription' => $errorInscription]
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

    public function contact() //TODO optionnel : "à mettre dans un service"
    {
        if (!empty($_POST['identity']) and !empty($_POST['email']) and !empty($_POST['message'])) {
            // = Create the Transport
            $transport = (new \Swift_SmtpTransport('in-v3.mailjet.com', 587))
            ->setUsername($_ENV['SMTP_USERNAME'])
            ->setPassword($_ENV['SMTP_PASSWORD'])
            ;

            // = Create the Mailer using your created Transport
            $mailer = new \Swift_Mailer($transport);

            // = Create a message
            $body = 'Nom : ' . $_POST['identity'] .
            PHP_EOL . 'Email : ' . $_POST['email'] .
            PHP_EOL . 'Message : ' . $_POST['message'];
            $message = (new \Swift_Message('Contact Helixsi.com'))
            ->setFrom(['julie@helixsi.com' => 'Julie Xaxa'])
            ->setTo(['julie@helixsi.com' => 'Julie Xaxa'])
            ->setBody($body)
            ->setSubject('Formulaire Contact HelixSI')
            ;

            // = Send the message
            //TODO optionnel : doublon code ci-dessous à améliorer
            $result = $mailer->send($message);
            Session::setFlash('successContact', 'Votre message a été envoyé');
            $this->home();
        } else {
            Session::setFlash('errorContact', 'Votre message n\'a pas pu être envoyé');
            $this->home();
        }
    }
            //TODO utiliser error ++ , avec un si error >0 alors //

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

    public function deconnexion()
    {
        Session::stop();
        $this->home();
    }

    public function inscription()
    {
        $firstName = Request::postData('firstNameInscription');
        $lastName = Request::postData('lastNameInscription');
        $mail = Request::postData('mailInscription');
        $pass = Request::postData('passInscription');
        $passCtrl = Request::postData('passInscriptionCtrl');

        $erreur_form = 0;

        //vérifie les $POST
        if (!isset($firstName) or !isset($lastName) or !isset($mail) or !isset($pass) or !isset($passCtrl)) {
            $erreur_form = 1;
            echo 'Il y a eu une erreur';
        }
                
        //Verif si le mail existe
        $userManager = new UserManager();
        $userMail = $userManager->getByMail($mail);
        if (isset($userMail)) {
            $erreur_form = 1;
            Session::setFlash('errorInscription', 'Votre mail est déjà inscrit');
        }

        //Vérif mots de passe identique
        if ($pass != $passCtrl) {
            $erreur_form = 1;
            Session::setFlash('errorInscription', 'Les mots de passe ne sont pas identiques');
        }

        //Verif si le mail est au format xx@xx.xx
        if (!preg_match('#^([\w\.-]+)@([\w\.-]+)(\.[a-z]{2,4})$#', $mail)) {
            $erreur_form = 1;
            Session::setFlash('errorInscription', 'Votre mail n\'est pas conforme');
        }

        if ($erreur_form == 1) { //s'il y a au moins une erreur
            $this->authentification();
        } else //s'il n'y a aucune erreur
        {
            //Hachage mot de passe
            $pass_hache = password_hash($_POST['pass'], PASSWORD_DEFAULT);

            $userNew = [];
            $userNew = [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $mail,
            'pass' => $pass_hache
            ];
            $userManager = new UserManager();
            $userManager->add($userNew);
            $this->home(); //TODO utiliser les redirections
        }
    }
}
