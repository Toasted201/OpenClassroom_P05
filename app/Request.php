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

    public static function postData(string $key, string $type = 'text')
    {
        if (isset($_POST[$key]) and $type == 'text') {
            return strip_tags($_POST[$key]);
        }
        return '';
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
