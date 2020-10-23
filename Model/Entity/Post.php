<?php

namespace Model\Entity;

class Post
{
    private $id;
    private $userId;
    private $content;
    private $title;
    private $chapo;
    private $publish;
    private $dateCreate;
    private $dateChange;
    //private $_posts = [];
    //private $_comments = [];

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
    public function userId()
    {
        return $this->userId;
    }
    public function content()
    {
        return $this->content;
    }
    public function title()
    {
        return $this->title;
    }
    public function chapo()
    {
        return $this->chapo;
    }
    public function publish()
    {
        return $this->publish;
    }
    public function dateCreate()
    {
        return $this->dateCreate;
    }
    public function dateChange()
    {
        return $this->dateChange;
    }


    // Setters

    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->id = $id;
        }
    }

    public function setUserId($userId)
    {
        if (is_string($userId)) {
            $this->userId = $userId;
        }
    }

    public function setContent($content)
    {
        if (is_string($content)) {
            $this->content = $content;
        }
    }

    public function setTitle($title)
    {
        if (is_string($title)) {
            $this->title = $title;
        }
    }

    public function setChapo($chapo)
    {
        if (is_string($chapo)) {
            $this->chapo = $chapo;
        }
    }
    public function setPublish($publish)
    {
        if (is_bool($publish)) {
            $this->publish = $publish;
        }
    }

    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;
    }

    public function setDateChange($dateChange)
    {
        $this->dateChange = $dateChange;
    }
}
