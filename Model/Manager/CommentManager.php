<?php

namespace Manager;

use Model\Entity\Comment;

class CommentManager extends BaseManager
{


    public function addComment($comment)
    {
        $db = $this->getDb();
        $req = $db->prepare('INSERT INTO comment(postId, userId, content, dateCreate, statut) 
            VALUES(:postId ,:userId, :content, NOW(), "attente")');
        $affectedLines = $req->execute([
            'userId' => $comment['userId'],
            'content' => $comment['content'],
            'postId' => $comment['postId']
        ]);
        $req->closeCursor();
        return $affectedLines;
    }


    public function getComments($idPost)
    {
        $db = $this->getDb();
        $req = $db->prepare('SELECT 
            comment.id,
            comment.postId, 
            comment.userId, 
            comment.content,
            comment.dateCreate,
            comment.statut,
            user.firstName,
            user.lastName,
            DATE_FORMAT(comment.dateCreate, \'%d/%m/%Y\') AS dateCreateFR
            FROM comment,user
            WHERE comment.userId = user.Id AND comment.postId = :postId
            ORDER BY dateCreate DESC');
        $req->execute([
            'postId' => $idPost
        ]);
        $comments = $req->fetchAll();
        $req->closeCursor();
        return $comments;
    }

    public function getWaitComments()
    {
        $db = $this->getDb();
        $req = $db->prepare('SELECT 
            comment.id,
            comment.postId, 
            comment.userId, 
            comment.content,
            comment.dateCreate,
            comment.statut,
            user.firstName,
            user.lastName,
            DATE_FORMAT(comment.dateCreate, \'%d/%m/%Y\') AS dateCreateFR
            FROM comment,user
            WHERE comment.userId = user.Id AND comment.statut = "attente"
            ORDER BY dateCreate DESC');
        $req->execute();
        $waitComments = $req->fetchAll();
        $req->closeCursor();
        return $waitComments;
    }

    public function statutUpdate($statutUpdate)
    {
        $db = $this->getDb();
        $req = $db->prepare('UPDATE comment SET statut=:statut WHERE id=:id');
        $req->execute([
            'statut' => $statutUpdate['statut'],
            'id' => $statutUpdate['id']
        ]);
    }
}
