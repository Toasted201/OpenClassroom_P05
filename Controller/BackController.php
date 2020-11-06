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
    public function denyAccessUnlessAdmin()
    {
        $userRole = '';
        $connectedUser = Session::auth();
        if (isset($connectedUser)) {
            $userRole = $connectedUser->userRole();
        }
        if ($userRole != 'admin') {
            header("Location: ?action=");
            exit;
        }
    }
         
    public function admin()
    {
        $this->denyAccessUnlessAdmin();
        echo $this->render('Back/admin.html.twig', []);
    }

    public function newPost()
    {
        $this->denyAccessUnlessAdmin();
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
        $this->denyAccessUnlessAdmin();
        $connectedUser = Session::auth();
        $userId = $connectedUser->getId();
        $title = Request::postData('titleNewPost');
        $chapo = Request::postData('chapoNewPost');
        $content = Request::postData('contentNewPost');
        $publish = Request::postData('publishNewPost');
        $error_form = false;
        if (!$error_form) {
            if (!isset($userId) or !isset($title) or !isset($chapo) or !isset($content) or !isset($publish)) {
                $error_form = true;
                Session::setFlash('errorNewPost', 'Il y a une erreur dans l\'envoi du formulaire');
            }
        }
        if ($error_form) {
            header("Location: ?action=newPost");
            exit;
        }
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


    public function editPostList()
    {
        $this->denyAccessUnlessAdmin();
        $managerPost = new PostManager();
        $posts = $managerPost->getPosts();
        echo $this->render('Back/editPostList.html.twig', ['listPosts' => $posts]);
    }

    public function editPostDetail($postId)
    {
        $this->denyAccessUnlessAdmin();
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
        $this->denyAccessUnlessAdmin();
        $title = Request::postData('titleEditPost');
        $chapo = Request::postData('chapoEditPost');
        $content = Request::postData('contentEditPost');
        $publish = Request::postData('publishEditPost');
        $userId = Request::postData('userIdEditPost');
        $postId = Request::postData('postId');
        $error_form = false;
        if (
            !isset($title) or
            !isset($chapo) or
            !isset($content) or
            !isset($userId) or
            !isset($publish) or
            !isset($postId)
        ) {
            $error_form = true;
            Session::setFlash('errorEditPost', 'Il y a une erreur dans l\'envoi du formulaire');
        }
        if ($error_form) {
            header("Location: ?action=editPostDetail&postId=$postId");
            exit;
        }
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

    public function validComment()
    {
        $this->denyAccessUnlessAdmin();
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
        $this->denyAccessUnlessAdmin();
        $statut = Request::postData('validComment');
        $id = Request::postData('commentId');
        $error_form = false ;
        if (
            !isset($statut) or
            !isset($id)
        ) {
            $error_form = true;
            Session::setFlash('errorValidComment', 'Il y a une erreur dans l\'envoi du formulaire');
        }
        if ($error_form) {
            header("Location: ?action=validComment");
            exit;
        }
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
