<?php

namespace Controller;

use Manager\PostManager;
use App\Session;
use App\Request;
use Manager\CommentManager;
use Manager\UserManager;
use Model\Entity\User;

class BackController extends BaseController
{
    public function admin()
    {
        echo $this->render('Back/admin.html.twig', []);
    }
    
    public function newPost()
    {
        $successNewPost = Session::Flash('successNewPost');
        $errorNewPost = Session::Flash('errorNewPost');
        echo $this->render('Back/newPost.html.twig', ['flashErrorNewPost' => $errorNewPost,
        'flashSuccessNewPost' => $successNewPost]);
    }

    public function addPost()
    {
        $connectedUser = Session::auth();
        $userId = $connectedUser->getId();
        $userRole = $connectedUser->userRole();
              $title = Request::postData('titleNewPost');
        $chapo = Request::postData('chapoNewPost');
        $content = Request::postData('contentNewPost');
        $publish = Request::postData('publishNewPost');

        $erreur_form = 0;

        //vérifie les $POST
        if (!isset($userId) or !isset($title) or !isset($chapo) or !isset($content) or !isset($publish)) {
            $erreur_form = 1;
            Session::setFlash('errorNewPost', 'Il y a une erreur dans l\'envoi du formulaire');
        }

        //vérifie le userRole
        if ($userRole != 'admin') {
            $erreur_form = 1;
            Session::setFlash('errorNewPost', 'Vous n\êtes pas connecté en tant qu\'admin');
        }

        if ($erreur_form == 1) { //s'il y a au moins une erreur
            $this->newPost();
        } else //s'il n'y a aucune erreur
        {
            $postNew = [];
            $postNew = [
            'userId' => $userId,
            'title' => $title,
            'chapo' => $chapo,
            'content' => $content,
            'publish' => $publish
            ];
            $postManager = new postManager();
            $postManager->add($postNew);
            Session::setFlash('successNewPost', 'Votre post a bien été enregistré');
            $this->newPost(); //TODO utiliser les redirections
        }
    }

    public function editPostList()
    {
        $managerPost = new PostManager();
        $posts = $managerPost->getPosts();
        echo $this->render('Back/editPostList.html.twig', [['listPosts' => $posts]]);
    }

    public function validComment()
    {
        echo $this->render('Back/validComment.html.twig', []);
    }
}
