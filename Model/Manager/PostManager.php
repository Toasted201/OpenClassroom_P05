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
        $req = $db->query('SELECT id, title, content, chapo, user_id , DATE_FORMAT(date_create, \'%d/%m/%Y à %Hh%imin%ss\') AS date_create_fr FROM post ORDER BY date_create DESC');
        $posts = $req->fetchAll();
        $req->closeCursor();
        return $posts;
    }

    public function getPostsHome()
    {
        $db = $this->getDb();
        $req = $db->query('SELECT id, title, content, chapo, user_id , DATE_FORMAT(date_create, \'%d/%m/%Y à %Hh%imin%ss\') AS date_create_fr FROM post ORDER BY date_create DESC LIMIT 3');
        $posts = $req->fetchAll();
        $req->closeCursor();
        return $posts;
    }

    public function getPost($postId)
    {
        $db = $this->getDb();
        $req = $db->prepare('SELECT id, title, content, chapo, user_id, DATE_FORMAT(date_create, \'%d/%m/%Y à %Hh%imin%ss\') AS date_create_fr FROM post WHERE id = :id');
        $req->execute(
            ['id' => $postId]
        );
        $post = $req->fetch();
        $req->closeCursor();
        return $post;
    }
}
