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

}