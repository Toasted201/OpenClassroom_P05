<?php

namespace Manager;

abstract class BaseManager
{

    protected $db = null;

    private function dbConnect()
    {
        if ($this->db === null) {
            $this->db =  new \PDO('mysql:host=' . $_SERVER['DB_HOST'] . ';dbname=' . $_SERVER['DB_NAME'] . ';charset=utf8', $_SERVER['DB_USERNAME'], $_SERVER['DB_PASSWORD'], array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
        }
    }

    protected function getDb()
    {
        $this->dbConnect();
        return $this->db;
    }
}
