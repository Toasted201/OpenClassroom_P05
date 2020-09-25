<?php

namespace Model\Entity;

class Post
{
    private $_id,
            $_author,
            $_content,
            $_title,
            $_publish,
            $_dateCreate,
            $_dateChange;
    private $_posts = [];
    private $_comments = [];

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
    public function author()
    {
        return $this->_author;
    }
    public function content()
    {
        return $this->_content;
    }
    public function title()
    {
        return $this->_title;
    }
    public function publish()
    {
        return $this->_publish;
    }
    public function dateCreate()
    {
        return $this->_dateCreate;
    }
    public function dateChange()
    {
        return $this->_dateChange;
    }


    // Setters

    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        }
    }

    public function setAuthor($author)
    {
        if (is_string($author)) {
            $this->_author = $author;
        }
    }

    public function setContent($content)
    {
        if (is_string($content)) {
            $this->_content = $content;
        }
    }

    public function setTitle($title)
    {
        if (is_string($title)) {
            $this->_title = $title;
        }
    }

    public function setPublish($publish)
    {
        if (is_bool($publish)) {
            $this->_publish = $publish;
        }
    }

    public function setDateCreate($dateCreate)
    {
        $this->_dateCreate = $dateCreate;
    } //TO DO

    public function setDateChange($dateChange)
    {
        $this->_dateChange = $dateChange;
    } //TO DO


}
