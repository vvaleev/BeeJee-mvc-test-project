<?php

namespace System\Sessions;

class Session
{
    public static function set($key, $value)
    {
        if (!$key || !$value) {
            return null;
        }

        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        if (!$key || !isset($_SESSION[$key])) {
            return null;
        }

        return $_SESSION[$key];
    }

    public static function remove($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy()
    {
        session_destroy();
    }

    public static function start()
    {
        @session_start();
    }
}
