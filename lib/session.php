<?php

class Session
{
    public function __construct()
    {
        session_start();
    }

    public function set($index, $value)
    {
        if (empty($index) && empty($value))
        {
            throw new Exception('No parameters has been initialize.');
        }
        else
        {
            $_SESSION[$index] = $value;
        }
    }

    public function get($index)
    {
        if (empty($index))
        {
            throw new Exception('No index parameter has been initialize.');
        }
        else
        {
            return $_SESSION[$index];
        }
    }

    public function destroy($index = null)
    {
        if (is_null($index))
        {
            session_destroy();
        }
        else
        {
            unset($_SESSION[$index]);
        }
    }
}