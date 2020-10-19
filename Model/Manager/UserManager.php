<?php

namespace Manager;

use Model\Entity\User;

class UserManager extends BaseManager
{
    public function __construct()
    {
    }

    public function add($userNew) //TODO Optionnel : utiliser class pour écrire
    {
        $db = $this->getDb();
        $req = $db->prepare('INSERT INTO user(firstName, lastName, email, pass, dateCreate, userRole) 
            VALUES(:firstName, :lastName, :email, :pass, NOW(), "visiteur")');
        $req->execute(
            [
                'firstName' => $userNew['firstName'],
                'lastName' => $userNew['lastName'],
                'email' => $userNew['email'],
                'pass' => $userNew['pass'],
            ]
        );
    }


    public function delete(User $user)
    {
        $db = $this->getDb();
        $db->execute('DELETE FROM user WHERE id = ' . $user->getId());
    }

    public function getById($id): ?User //TODO optionnel : req->setFetchMode pour raccourci
    {
        $db = $this->getDb();
        $req = $db->prepare('SELECT * FROM user WHERE id= :id');
        $req->execute(array(
            'id' => $id
        ));
        $data = $req->fetch();
        if ($data === false) {
            return null;
        } else {
            return new User($data);
        };
    }

    public function getByMail($mail): ?User
    {
        $db = $this->getDb();
        $req = $db->prepare('SELECT * FROM user WHERE email = :email');
        $req->execute(
            ['email' => $mail]
        );
        
        $data = $req->fetch();

        if ($data === false) {
            return null;
        } else {
            $user = new User($data);
            return $user;
        }
    }
    
    public function getFromSession($idSession): ?User
    {
        $db = $this->getDb();
        $req = $db->prepare('SELECT * FROM user WHERE id = :id');
        $req->execute(
            ['id' => $idSession]
        );
        $data = $req->fetch();
        if ($data === false) {
            return null;
        } else {
            return new User($data);
        }
    }


    public function getList(): array
    {
        $db = $this->getDb();
        $users = [];
        $req = $db->query('SELECT * FROM user');
        while ($data = $req->fetch()) {
            $users[] = new User($data);
        }
        $req->closeCursor();
        return $users;
    }

    public function update(User $user)
    {
        $db = $this->getDb();
        $req = $db->prepare('UPDATE INTO user 
            SET firstName = :firstName, lastName = :lastName, pass = :pass, userRole = :userRole 
            WHERE id = :id');
        $req->execute(
            [
                'firstName' => $user->firstName(),
                'lastName' => $user->lastName(),
                'pass' => $user->pass(),
                'role' => $user->userRole()
            ]
        );
    }
}
