<?php
namespace App;

class Request
{
    public static function get(string $key)
    {
        if(isset($_GET[$key])) {
            return $_GET[$key];
        }
        return '';
    }

    public static function post(string $key)
    {
        return $_POST[$key];
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function dbhost()
    {
        if (!isset($_SERVER['DB_HOST'])) {
            throw new \Exception('DB_Host non défini');
        } else {
            return $_SERVER['DB_HOST'];   
        }
    }

    public static function dbusername()
    {
        if (!isset($_SERVER['DB_USERNAME'])) {
            throw new \Exception('DB_USERNAME non défini');
        } else {
            return $_SERVER['DB_USERNAME'];   
        }
    }

    public static function dbname()
    {
        if (!isset($_SERVER['DB_USERNAME'])) {
            throw new \Exception('DB_NAME non défini');
        } else {
            return $_SERVER['DB_NAME'];   
        }
    }

    public static function dbpassword()
    {
        if (!isset($_SERVER['DB_PASSWORD'])) {
            throw new \Exception('DB_PASSWORD non défini');
        } else {
            return $_SERVER['DB_PASSWORD'];   
        }
    }     
}