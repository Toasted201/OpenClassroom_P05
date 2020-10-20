<?php

namespace Manager;

use App\Request;

abstract class BaseManager
{

    protected $db = null;

    private function dbConnect()
    {
        if ($this->db === null) {
            $this->db =  new \PDO(
                'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8',
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD'],
                array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
            );
        }
    }

    protected function getDb()
    {
        $this->dbConnect();
        return $this->db;
    }
}
