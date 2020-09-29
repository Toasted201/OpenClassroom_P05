<?php

namespace App;

class Session
{
    private static $instance = null;

    public static function __callStatic($name, $arguments)
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : 'undefined';
    }

    public static function start()
    {
        if(!self::$instance) {
            session_start();
        }

        session_regenerate_id();
    }

    public static function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

}