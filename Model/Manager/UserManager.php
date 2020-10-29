<?php

namespace Manager;

use Model\Entity\User;

class UserManager extends BaseManager
{
    public function __construct()
    {
    }

    public function add(User $userNew)
    {
        $db = $this->getDb();
        $req = $db->prepare('INSERT INTO user(firstName, lastName, email, pass, dateCreate, userRole) 
            VALUES(:firstName, :lastName, :email, :pass, NOW(), "visiteur")');
        $req->execute(
            [
                'firstName' => $userNew->firstName(),
                'lastName' => $userNew->lastName(),
                'email' => $userNew->email(),
                'pass' => $userNew->pass(),
            ]
        );
    }


    public function delete(User $user)
    {
        $db = $this->getDb();
        $db->execute('DELETE FROM user WHERE id = ' . $user->getId());
    }

    public function getById($id): ?User
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
    
/*  public function getFromSession($idSession): ?User
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
*/

    public function getList(): array
    {
        $db = $this->getDb();
        $users = [];
        $req = $db->prepare('SELECT * FROM user');
        $req->execute();
        while ($data = $req->fetch()) {
            $users[] = new User($data);
        }
        $req->closeCursor();
        return $users;
    }

    public function update(User $user)
    {
        $db = $this->getDb();
        $req = $db->prepare('UPDATE user
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

    public function attaques(User $user) // ajoute 1 attaque, à date du jour, à l'utilisateur
    {
        $db = $this->getDb();
        $dateJour = date('Y-m-d');
        if ($user->dateBF() != $dateJour) {  //si la date d'attaque de l'utilisateur est différente d'aujourd'hui alors
            $user->setNbAttaques(0); //on attribue 0 au nb d'attaque de l'utilisateur
        }
        $req = $db->prepare('UPDATE user SET nbAttaques = :nbAttaques, dateBF = NOW() WHERE id = :userId');
        $req->execute(
            [
                'nbAttaques' =>  $user->nbAttaques() + 1,
                'userId' => $user->getId()
            ]
        );
        $req->closeCursor();
        $user->setNbAttaques($user->nbAttaques() + 1);
        return $user;
    }
}
