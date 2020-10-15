<?php

namespace App;

class Request
{
    public static function getData(string $key)
    {
        if (isset($_GET[$key])) {
            return $_GET[$key];
        }
        return '';
    }

    public static function postData(string $key)
    {
        if (isset($_POST[$key])) {
            return $_POST[$key];
        }
        return '';
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
