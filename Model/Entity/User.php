<?php

namespace Model\Entity;

class User
{
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $pass;
    private $dateCreate;
    private $dateLastConnexion;
    private $userRole;
    private $dateBF;
    private $nbAttaques;
    
    //implementer le constructeur - fonction appelée quand on fait un new User
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
    public function firstName()
    {
        return $this->firstName;
    }
    public function lastName()
    {
        return $this->lastName;
    }
    public function email()
    {
        return $this->email;
    }
    public function pass()
    {
        return $this->pass;
    }
    public function dateCreate()
    {
        return $this->dateCreate;
    }
    public function dateLastConnexion()
    {
        return $this->dateLastConnexion;
    }
    public function userRole()
    {
        return $this->userRole;
    }
    public function dateBF()
    {
        return $this->dateBF;
    }
    public function nbAttaques()
    {
        return $this->nbAttaques;
    }

    // Setters
    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->id = $id;
        }
    }

    public function setFirstName($firstName)
    {
        if (is_string($firstName)) {
            $this->firstName = $firstName;
        }
    }

    public function setLastName($lastName)
    {
        if (is_string($lastName)) {
            $this->lastName = $lastName;
        }
    }

    public function setEmail($email)
    {
        if (is_string($email)) {
            $this->email = $email;
        }
    }

    public function setPass($pass)
    {
        if (!empty($pass)) {
            $this->pass = $pass;
        }
    }

    public function checkPass($passPlain)
    {
        return password_verify($passPlain, $this->pass);
    }

    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;
    }

    public function setDateLastConnexion($dateLastConnexion)
    {
        $this->dateLastConnexion = $dateLastConnexion;
    }

    public function setUserRole($userRole)
    {
        if (is_string($userRole)) {
            $this->userRole = $userRole;
        }
    }

    public function setNbAttaques($nbAttaques)
    {
        $this->nbAttaques = $nbAttaques;
    }

    public function setDateBF($dateBF)
    {
        $this->dateBF = $dateBF;
    }
}
