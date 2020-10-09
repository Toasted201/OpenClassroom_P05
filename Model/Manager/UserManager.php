<?php

namespace Manager;

use Model\Entity\User;

class UserManager extends BaseManager
{
    /*
  private $_db; // Instance de PDO.

  public function __construct($db)
  {
    $this->setDb($db);
  }
  */

    public function add(User $user)
    {
        $req = $this->_db->prepare('INSERT INTO user(first_name, last_name, email, pass, date_creation, userRole) 
            VALUES(:firstName, :lastName, :email, :pass, NOW(), :type)');
        $req->execute(
            [
                'firstName' => $user->firstName(),
                'lastName' => $user->lastName(),
                'email' => $user->email(),
                'pass' => $user->pass(),
                'userRole' => $user->userRole()
            ]
        );

        $user->hydrate(
            ['id' => $this->_db->LastInsertId()]
        );
    }


    public function delete(User $user)
    {
        $this->_db->execute('DELETE FROM user WHERE id = ' . $user->getId());
    }

    public function get($id)
    {
        $req = $this->_db->query('SELECT id, nom, degats FROM user WHERE id=' . $id);
        $data = $req->fetch();
        return new User($data);
    }


    public function getList()
    {
        $users = [];
        $req = $this->_db->query('SELECT * FROM user');
        while ($data = $req->fetch()) {
            $users[] = new User($data);
        }
        $req->closeCursor();
        return $users;
    }

    public function update(User $user)
    {
        $req = $this->_db->prepare('UPDATE INTO user 
            SET firstName = :firstName, last_name = :last_name, pass = :pass, userRole = :userRole 
            WHERE id = :id');
        $req->execute(
            [
                'firstNama' => $user->firstName(),
                'lastName' => $user->lastName(),
                'pass' => $user->pass(),
                'role' => $user->userRole()
            ]
        );
    }

    /*
  public function setDb(PDO $db){
    $this->_db = $db;
  }
  */
}
