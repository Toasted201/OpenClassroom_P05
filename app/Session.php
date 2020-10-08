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
        if (!self::$instance) {
            session_start();
        }

        session_regenerate_id();
    }

    public static function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function setFlash($key, $value)
    {
        $_SESSION['flash'][$key] = $value;
    }

    public static function flash($key)
    {
        if (isset($_SESSION['flash'][$key])) {
            $flash = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $flash;
        }
    }
}
