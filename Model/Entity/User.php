<?php

namespace Model\Entity;

class User
{
    private $_id,
        $_firstName,
        $_lastName,
        $_email,
        $_pass,
        $_dateCreate,
        $_dateLastConnexion,
        $_userRole;
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
    public function firstName()
    {
        return $this->_firstName;
    }
    public function lastName()
    {
        return $this->_lastName;
    }
    public function email()
    {
        return $this->_email;
    }
    public function pass()
    {
        return $this->_pass;
    }
    public function dateCreate()
    {
        return $this->_dateCreate;
    }
    public function dateLastConnexion()
    {
        return $this->_dateLastConnexion;
    }
    public function userRole()
    {
        return $this->_userRole;
    }

    // Setters
    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        }
    }

    public function setFirstName($firstName)
    {
        if (is_string($firstName)) {
            $this->_fisrtName = $firstName;
        }
    }

    public function setLasttName($lastName)
    {
        if (is_string($lastName)) {
            $this->_lastName = $lastName;
        }
    }

    public function setEmail($email)
    {
        if (is_string($email)) {
            $this->_email = $email;
        }
    }

    public function setPass($pass)
    {
        if (!empty($pass)) {
            $this->_pass = password_hash($pass, PASSWORD_DEFAULT);
        }
    }

    public function checkPass($pass)
    {
        return password_verify($pass, $this->pass);
    }

    public function setDateCreate($dateCreate)
    {
        $this->_dateCreate = $dateCreate;
    }  // TO DO   

    public function setDateLastConnexion($dateLastConnexion)
    {
        $this->_dateLastConnexion = $dateLastConnexion;
    } //TO DO 

    public function setUserRole($userRole)
    {
        if (is_string($userRole)) {
            $this->_userRole = $userRole;
        }
    }


    function isLoggedIn()
    {
        return !empty($_SESSION['pseudo']);
    }
}
