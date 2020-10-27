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
        echo $this->render(
            'Back/newPost.html.twig',
            ['flashErrorNewPost' => $errorNewPost,
            'flashSuccessNewPost' => $successNewPost]
        );
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
        if (!isset($userId) or !isset($title) or !isset($chapo) or !isset($content) or !isset($publish)) {
            $erreur_form = 1;
            Session::setFlash('errorNewPost', 'Il y a une erreur dans l\'envoi du formulaire');
        }
        if ($userRole != 'admin') {
            $erreur_form = 1;
            Session::setFlash('errorNewPost', 'Vous n\êtes pas connecté en tant qu\'admin');
        }
        if ($erreur_form == 1) {
            header("Location: ?action=newPost");
            exit;
        } else {
            $post = new Post(
                ['userId' => $userId,
                'title' => $title,
                'chapo' => $chapo,
                'content' => $content,
                'publish' => $publish
                ]
            );
            $postManager = new postManager();
            $postManager->add($post);
            Session::setFlash('successNewPost', 'Votre post a bien été enregistré');
            header("Location: ?action=newPost");
            exit;
        }
    }

    public function editPostList()
    {
        $managerPost = new PostManager();
        $posts = $managerPost->getPosts();
        echo $this->render('Back/editPostList.html.twig', ['listPosts' => $posts]);
    }

    public function editPostDetail($postId)
    {
        $successEditPost = Session::Flash('successEditPost');
        $errorEditPost = Session::Flash('errorEditPost');
        $managerPost = new PostManager();
        $managerUser = new UserManager();
        $users = $managerUser->getList();
        $post = $managerPost->getPost($postId);
        echo $this->render(
            'Back/editPostDetail.html.twig',
            ['post' => $post, 'listUsers' => $users,
            'flashSuccessEditPost' => $successEditPost,
            'flashErroEditPost' => $errorEditPost]
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
        $connectedUser = Session::auth();
        $userRole = $connectedUser->userRole();
        $erreur_form = 0;
        if (
            !isset($title) or
            !isset($chapo) or
            !isset($content) or
            !isset($userId) or
            !isset($publish) or
            !isset($postId)
        ) {
            $erreur_form = 1;
            Session::setFlash('errorEditPost', 'Il y a une erreur dans l\'envoi du formulaire');
        }
        if ($userRole != 'admin') {
            $erreur_form = 1;
            Session::setFlash('errorEditPost', 'Vous n\êtes pas connecté en tant qu\'admin');
        }
        if ($erreur_form == 1) {
            header("Location: ?action=editPostDetail&postId=$postId");
            exit;
        } else {
            $post = new Post(
                ['title' => $title,
                'chapo' => $chapo,
                'content' => $content,
                'publish' => $publish,
                'id' => $postId,
                'userId' => $userId
                ]
            );
            $postManager = new postManager();
            $postManager->update($post);
            Session::setFlash('successEditPost', 'Votre post a bien été modifié');
            header("Location: ?action=editPostDetail&postId=$postId");
            exit;
        }
    }

    public function validComment()
    {
        $managerComment = new CommentManager();
        $waitComments = $managerComment->getWaitComments();
        $errorEditComment = Session::Flash('errorEditComment');
        echo $this->render(
            'Back/validComment.html.twig',
            ['listComments' => $waitComments, 'flashErrorEditComment' => $errorEditComment]
        );
    }

    public function validCommentForm()
    {
        $statut = Request::postData('validComment');
        $id = Request::postData('commentId');
        $connectedUser = Session::auth();
        $userRole = $connectedUser->userRole();
        $erreur_form = false ;
        if (
            !isset($statut) or
            !isset($id)
        ) {
            $erreur_form = true;
            Session::setFlash('errorValidComment', 'Il y a une erreur dans l\'envoi du formulaire');
        }
        if ($userRole != 'admin') {
            $erreur_form = true;
            Session::setFlash('errorValidPost', 'Vous n\êtes pas connecté en tant qu\'admin');
        }
        if ($erreur_form == true) {
            header("Location: ?action=validComment");
            exit;
        } else {
            $statutUpdate = [];
            $statutUpdate = [
            'statut' => $statut,
            'id' => $id
            ];
            $commentManager = new CommentManager();
            $commentManager->statutUpdate($statutUpdate);
            header("Location: ?action=validComment");
            exit;
        }
    }
}
