<?php

namespace Manager;

use Model\Entity\Post;

class PostManager extends BaseManager
{
    /*
  private $_db; // Instance de PDO.

  public function __construct($db)
  {
      $this->setDb($db);
  }
  */

    public function getPosts()
    {
        $db = $this->getDb();
        $req = $db->query('SELECT id, 
            title, 
            chapo, 
            userId,
            CASE 
                WHEN dateChange IS null THEN DATE_FORMAT(dateCreate, \'%d/%m/%Y\') 
                ELSE DATE_FORMAT(dateChange, \'%d/%m/%Y\') END AS dateLast
            FROM post ORDER BY dateLast DESC');
        $posts = $req->fetchAll();
        $req->closeCursor();
        return $posts;
    }

    public function getPostsHome()
    {
        $db = $this->getDb();
        $req = $db->query('SELECT id, 
            title, 
            content, 
            chapo, 
            userId , 
            DATE_FORMAT(dateCreate, \'%d/%m/%Y à %Hh%imin%ss\') AS dateCreateFr 
            FROM post ORDER BY dateCreate DESC LIMIT 3');
        $posts = $req->fetchAll();
        $req->closeCursor();
        return $posts;
    }

    public function getPost($postId)
    {
        $db = $this->getDb();
        $reqPost = $db->prepare('SELECT post.id, 
            post.title, 
            post.content, 
            post.chapo, 
            post.userId, 
            user.firstName, 
            user.lastName,
            CASE 
                WHEN post.dateChange IS null THEN DATE_FORMAT(post.dateCreate, \'%d/%m/%Y\') 
                ELSE DATE_FORMAT(post.dateChange, \'%d/%m/%Y\') END AS dateLast
            FROM post, user
            WHERE post.userId = user.id AND post.id = :id');
        $reqPost->execute(
            ['id' => $postId]
        );
        $post = $reqPost->fetch();
        $reqPost->closeCursor();
        return $post;
    }
}
