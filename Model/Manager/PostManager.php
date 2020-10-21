<?php

namespace Manager;

use Model\Entity\Post;

class PostManager extends BaseManager
{
    public function __construct()
    {
    }
    
    public function getPosts()
    {
        $db = $this->getDb();
        $req = $db->query('SELECT id, 
                    title, 
                    chapo, 
                    userId,
                    publish,
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
                    publish, 
                    DATE_FORMAT(dateCreate, \'%d/%m/%Y à %Hh%imin%ss\') AS dateCreateFr 
                    FROM post 
                    WHERE publish=1
                    ORDER BY dateCreate DESC LIMIT 3');
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
                    post.publish,
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

    public function add($newPost)
    {
        $db = $this->getDb();
        $req = $db->prepare('INSERT INTO post(userId, title, chapo, content, publish, dateCreate)
                    VALUES(:userId, :title, :chapo, :content, :publish, NOW())');
        $req->execute(
            [
                'userId' => $newPost['userId'],
                'title' => $newPost['title'],
                'chapo' => $newPost['chapo'],
                'content' => $newPost['content'],
                'publish' => $newPost['publish']
            ]
        );
    }

    public function update($editPost)
    {
        $db = $this->getDB();
        $req = $db->prepare(
            'UPDATE post
            SET userId = :userId,
            title = :title,
            chapo = :chapo,
            content = :content,
            publish = :publish,
            dateChange = NOW()
            WHERE id = :id'
        );
        $req->execute(
            [
                'userId' => $editPost['userId'],
                'title' => $editPost['title'],
                'chapo' => $editPost['chapo'],
                'content' => $editPost['content'],
                'publish' => $editPost['publish'],
                'id' => $editPost['postId']
            ]
        );
    }
}
