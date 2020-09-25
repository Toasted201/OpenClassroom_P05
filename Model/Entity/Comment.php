<?php

namespace Model\Entity;

class Comment
{
    private $_id,
        $_post_id,
        $_user_id,
        $_content,
        $_dateCreate,
        $_statut;
    private $_post = [];
    private $_user = [];

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
    public function id()
    {
        return $this->_id;
    }
    public function post_id()
    {
        return $this->_post_id;
    }
    public function author()
    {
        return $this->_author;
    }
    public function content()
    {
        return $this->_content;
    }
    public function dateCreate()
    {
        return $this->_dateCreate;
    }
    public function statut()
    {
        return $this->_statut;
    }


    // Setters

    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        }
    }

    public function setPost($post)
    {
        if (is_int($post)) {
            $this->_post = $post;
        }
    }

    public function setAuthor($author)
    {
        if (is_int($author)) {
            $this->_author = $author;
        }
    }

    public function setContent($content)
    {
        if (is_string($content)) {
            $this->_content = $content;
        }
    }

    public function setDateCreate($dateCreate)
    {
        $this->_dateCreate = $dateCreate;
    }

    public function setStatut($statut)
    {
        if (is_string($statut)) {
            $this->_statut = $statut;
        }
    }
}
