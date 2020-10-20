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
    
    public function addPost()
    {
        echo $this->render('Back/addPost.html.twig', []);
    }

    public function editPost()
    {
        echo $this->render('Back/editPost.html.twig', []);
    }

    public function validComment()
    {
        echo $this->render('Back/validComment.html.twig', []);
    }
}
