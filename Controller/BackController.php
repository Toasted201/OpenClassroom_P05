<?php

namespace Controller;

use Manager\PostManager;
use App\Session;
use App\Request;
use Manager\CommentManager;
use Manager\UserManager;
use Model\Entity\User;
use Model\Entity\Post;

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
        echo $this->render('Back/editPostList.html.twig', ['listPosts' => $posts]);
    }

    public function editPostDetail($postId) //TODO FLASH n'apparait pas
    {
        $successEditPost = Session::Flash('successEditPost');
        $managerPost = new PostManager();
        $managerUser = new UserManager();
        $users = $managerUser->getList();
        $post = $managerPost->getPost($postId);
        echo $this->render(
            'Back/editPostDetail.html.twig',
            ['post' => $post, 'listUsers' => $users,
            'flashSuccessEditPost' => $successEditPost]
        );
    }
    
    public function updatePost()
    {
        $title = Request::postData('titleEditPost');
        $chapo = Request::postData('chapoEditPost');
        $content = Request::postData('contentEditPost');
        $publish = Request::postData('publishEditPost');
        $userId = Request::postData('userIdEditPost');
        $postId = Request::postData('postId');
        $postEdit = [];
        $postEdit = [
        'userId' => $userId, //TODO récupérer valeur modifiée de la liste déroulante
        'title' => $title,
        'chapo' => $chapo,
        'content' => $content,
        'publish' => $publish,
        'postId' => $postId
        ];
        $postManager = new postManager();
        $postManager->update($postEdit);
        Session::setFlash('successEditPost', 'Votre post a bien été modifié');
        $this->editPostDetail($postId);
    }

    public function validComment()
    {
        echo $this->render('Back/validComment.html.twig', []);
    }
}
