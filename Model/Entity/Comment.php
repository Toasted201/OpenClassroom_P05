<?php

namespace Model\Entity;

class Comment
{
    private $id;
    private $postId;
    private $userId;
    private $content;
    private $dateCreate;
    private $statut;
    private $post = [];
    //private $_user = [];

    //implementer le constructeur
    public function __construct($datas)
    {
        $this->hydrate($datas);
    }


    //hydratation
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function postId()
    {
        return $this->postId;
    }
    public function userId()
    {
        return $this->userId;
    }
    public function content()
    {
        return $this->content;
    }
    public function dateCreate()
    {
        return $this->dateCreate;
    }
    public function statut()
    {
        return $this->statut;
    }


    // Setters

    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->id = $id;
        }
    }

    public function setPost($post)
    {
        if (is_int($post)) {
            $this->post = $post;
        }
    }

    public function setUserId($userId)
    {
        if (is_int($userId)) {
            $this->userId = $userId;
        }
    }

    public function setContent($content)
    {
        if (is_string($content)) {
            $this->content = $content;
        }
    }

    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;
    }

    public function setStatut($statut)
    {
        if (is_string($statut)) {
            $this->statut = $statut;
        }
    }
}
