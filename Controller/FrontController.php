<?php

namespace Controller;

use Manager\PostManager;
use App\Session;
use App\Request;
use Manager\UserManager;

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

    public function authentification()
    {
        echo $this->render('Front/authentification.html.twig', []);
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
        $this->home();
    }
    //TO DO utiliser error ++ , avec un si error >0 alors //

    public function connexion()
    {
        $mail = Request::post('mailConnect'); //Je définie une variable $mail et lui attribue le résultat de la fonction Post (=méthode de la classe Requete) avec le paramètre 'mailconnect'.
        $pass = Request::post('passConnect'); // idem
        $userManager = new UserManager(); // je crée une instance de la classe UserManager, que je nomme $userManager
        $user = $userManager->getByMail($mail); // J'invoque la méhode getByMail (avec le paramètre $mail) sur l'objet UserManager . Je place le résultat dans une variable $user
        if ($user === null) {
            echo 'le mail n\'existe pas';
        } else {
            $isPasswordCorrect = password_verify($pass, $user->pass());
            if (!$isPasswordCorrect) {
                echo 'le mot de passe est incorrect';
            } else {
                $prenom = Session::set('firstName', $user->firstName()); // J'appelle la fonction static Set de la classe Session avec deux paramètres (1/ la clé de _Session 2/la valeur que je veut y mettre -> j'invoque la méthode firstName sur l'objet $user)
                return $prenom;
            }
        }
    }
}
