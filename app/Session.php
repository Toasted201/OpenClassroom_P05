<?php

namespace App;

use Model\Entity\User;

class Session
{
    private static $instance = null;

    public static function __callStatic($name, $arguments) //fonction appelée si on ne précise pas de fonction
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    public static function start()
    {
        if (!self::$instance) {
            session_start();
        }

        session_regenerate_id();
    }

    public static function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public static function getGlobals()
    {
        return $_SESSION;
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

    public static function auth(): ?User
    {
        if (empty(Session::connectedUser())) {
            $connectedUser = null;
        } else {
            $connectedUser = unserialize(Session::get('connectedUser'));
        }
        return $connectedUser;
    }
}
