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
        return $_SERVER['DB_HOST'];
    }

    public static function dbusername()
    {
        return $_SERVER['DB_USERNAME'];
    }
    public static function dbname()
    {
        return $_SERVER['DB_NAME'];
    }
    public static function dbpassword()
    {
        return $_SERVER['DB_PASSWORD'];
    }        
}