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

    function getPosts()
    {
        $db = $this->getDb();
        $req = $db->query('SELECT id, title, content, author, DATE_FORMAT(dateCreate, \'%d/%m/%Y à %Hh%imin%ss\') AS dateCreateFR FROM post ORDER BY dateCreate DESC');
        $posts = $req->fetchAll();
        $req->closeCursor();
        return $posts;
    }

    function getPost(Post $post)
    {
        $db = $this->getDb();
        $req = $db->prepare('SELECT id, title, content, author, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM post WHERE id = :id');
        $req->execute(
            ['id' => $post->Id()]
        );
        $post = $req->fetch();
        $req->closeCursor();
        return $post;
    }
}
