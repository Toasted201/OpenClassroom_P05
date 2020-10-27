<?php

namespace Controller;

use Manager\PostManager;
use App\Session;
use App\Request;
use Manager\CommentManager;
use Manager\UserManager;
use Model\Entity\Comment;
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
        $managerPost = new PostManager();
        $posts = $managerPost->getPosts();
        echo $this->render('Front/posts.html.twig', ['listPosts' => $posts]);
    }

        
    public function post($postId)
    {
        $successComment = Session::Flash('successComment');
        $statut = "valide";
        $managerPost = new PostManager();
        $post = $managerPost->getPost($postId);
        $managerComment = new CommentManager();
        $comments = $managerComment->getComments($post['id']);
        $commentsValide = [];
        foreach ($comments as $comment) {
            if ($comment['statut'] === $statut) {
                $commentsValide[] = $comment;
            }
        }
        echo $this->render(
            'Front/post.html.twig',
            ['post' => $post,
            'comments' => $commentsValide,
            'flashSuccess' => $successComment]
        );
    }

    public function authentification()
    {
                
        $errorConnexion = Session::Flash('errorConnexion');
        $errorInscription = Session::Flash('errorInscription');
        $successInscription = Session::Flash('successInscription');
        echo $this->render(
            'Front/authentification.html.twig',
            ['flashError' => $errorConnexion,
            'flashErrorInscription' => $errorInscription,
            'flashSuccessInscription' => $successInscription]
        );
    }

    public function curriculum()
    {
        echo $this->render('Front/cv.html.twig', []);
    }

    public function contact()
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
            $result = $mailer->send($message);
            Session::setFlash('successContact', 'Votre message a été envoyé');
        } else {
            Session::setFlash('errorContact', 'Votre message n\'a pas pu être envoyé');
        }
            header("Location: ?action=");
            exit;
    }

    public function connexion()
    {
        $dateJour = date('Y-m-d');
        $mail = Request::postData('mailConnect');
        $passPlain = Request::postData('passConnect'); //récupération du mot de pass saisie
        $userManager = new UserManager();
        $user = $userManager->getByMail($mail); //récupération des données du user depuis son mail
        if ($user === null) {
            Session::setFlash('errorConnexion', 'Le mail n\'existe pas');
            header("Location: ?action=authentification");
            exit;
        } else {
            if (($user-> nbAttaques() > 20) and ($user->dateBF() === $dateJour)) {
                Session::setFlash('errorConnexion', 'Trop de tentative de connexion pour aujoud\'hui ');
                header("Location: ?action=authentification");
                exit;
            } else {
                $checkPass = $user->checkPass($passPlain);
                if (!$checkPass) {
                    Session::setFlash('errorConnexion', 'Le mot de passe est incorrect ');
                    $userManager->attaques($user);
                    header("Location: ?action=authentification");
                    exit;
                } else {
                    Session::set('connectedUser', serialize($user));
                    header("Location: ?action=");
                    exit;
                }
            }
        }
    }

    public function deconnexion()
    {
        Session::stop();
        header("Location: ?action=");
        exit;
    }

    public function inscription()
    {
        $firstName = Request::postData('firstNameInscription');
        $lastName = Request::postData('lastNameInscription');
        $mail = Request::postData('mailInscription');
        $pass = Request::postData('passInscription');
        $passCtrl = Request::postData('passInscriptionCtrl');

        $erreur_form = 0;

        // vérifie les $POST
        if (!isset($firstName) or !isset($lastName) or !isset($mail) or !isset($pass) or !isset($passCtrl)) {
            $erreur_form = 1;
            Session::setFlash('errorInscription', 'Il y a eu une erreur');
        }
        
         //Verif si le mail existe dans la db
        if ($erreur_form = 0) {
            $userManager = new UserManager();
            $userMail = $userManager->getByMail($mail);
            if (isset($userMail)) {
                $erreur_form = 1;
                Session::setFlash('errorInscription', 'Votre mail est déjà inscrit');
            }
        }
        //Vérif si les mots de passe du formulaire sont identiques
        if ($erreur_form = 0) {
            if ($pass != $passCtrl) {
                $erreur_form = 1;
                Session::setFlash('errorInscription', 'Les mots de passe ne sont pas identiques');
            }
        }
        //Verif si le mail du formulaire est au format xx@xx.xx
        if ($erreur_form = 0) {
            if (!preg_match('#^([\w\.-]+)@([\w\.-]+)(\.[a-z]{2,4})$#', $mail)) {
                $erreur_form = 1;
                Session::setFlash('errorInscription', 'Votre mail n\'est pas conforme');
            }
        }

        if ($erreur_form == 1) {
            header("Location: ?action=authentification");
            exit;
        } else {
            //Hachage mot de passe
            $pass_hache = password_hash($pass, PASSWORD_DEFAULT);
            //Nouvelle instance User avec les informations du formulaire
            $user = new User(
                ['firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $mail,
                'pass' => $pass_hache
                ]
            );
            $userManager = new UserManager();
            $userManager->add($user);
            Session::setFlash('successInscription', 'Votre compte été créé, vous pouvez vous connecter');
            header("Location: ?action=authentification");
            exit;
        }
    }

    public function addComment()
    {
        $postId = Request::postData('postId');
        $content = Request::postData('commentContent');
        $connectedUser = Session::auth();
        $userId = $connectedUser->getId();
        $comment = new Comment(
            ['postId' => $postId,
            'content' => $content,
            'userId' => $userId]
        );
        $commentManager = new CommentManager();
        $commentManager->addComment($comment);
        Session::setFlash('successComment', 'Votre commentaire a été soumis pour validation');
        header("Location: ?action=post&postId=$postId");
        exit;
    }
}
