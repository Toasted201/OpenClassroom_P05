<?php

namespace Manager;
use App\Request;

abstract class BaseManager
{

    protected $db = null;

    private function dbConnect()
    {
        $db_host = Request::dbhost();
        $db_name = Request::dbname(); 
        $db_username = Request::dbusername(); 
        $db_password = Request::dbpassword();    
        if ($this->db === null) {
            $this->db =  new \PDO('mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8', $db_username, $db_password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        }
    }

    protected function getDb()
    {
        $this->dbConnect();
        return $this->db;
    }
}
