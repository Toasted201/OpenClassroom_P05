<?php

namespace Manager;

use Model\Entity\Comment;

class CommentManager extends BaseManager
{


    public function postComment(Comment $comment)
    {
        $db = $this->getDb();
        $req = $db->prepare('INSERT INTO comment(post, author, content, date_create) VALUES(:post ,:author, :content, NOW())');
        $affectedLines = $req->execute([
            'author' => $comment->author(),
            'content' => $comment->content(),
            'post' => $comment->post_id()
        ]);
        $req->closeCursor();
        return $affectedLines;
    }


    public function getComments($id_post)
    {
        $db = $this->getDb();
        $req = $db->prepare('SELECT id, author, comment, DATE_FORMAT(date_create, \'%d/%m/%Y à %Hh%imin%ss\') AS dateCreateFR FROM comment WHERE post = :post ORDER BY date_create DESC');
        $req->execute([
            'post' => $id_post
        ]);
        $comments = $req->fetchAll();
        $req->closeCursor();
        return $comments;
    }
}
