<?php

class Application
{
    public function __construct()
    {
        $this->__set_error_reporting();
        $this->__remove_magic_quotes();
        $this->__unregister_globals();
    }

    private function __set_error_reporting()
    {
        if (DEVELOPMENT_ENVIRONMENT == true)
        {
            error_reporting(E_ALL);
            error_reporting(E_ERROR | E_PARSE);
            ini_set('display_errors','On');
        }
        else
        {
            error_reporting(E_ALL);
            ini_set('display_errors','Off');
            //ini_set('log_errors', 'On');
            //ini_set('error_log', ROOT . DS . 'tmp' . DS . 'logs' . DS . 'error.log'); // for recording error logs on a .log file
        }
    }

    private function __strip_slashes_deep($value)
    {
        $value = is_array($value) ? array_map(array($this, 'strip_slashes_deep',), $value) : stripslashes($value);
        return $value;
    }

    private function __remove_magic_quotes()
    {
        if (get_magic_quotes_gpc())
        {
            $_GET = $this->__strip_slashes_deep($_GET);
            $_POST = $this->__strip_slashes_deep($_POST);
            $_COOKIE = $this->__strip_slashes_deep($_COOKIE);
        }
    }

    private function __unregister_globals()
    {
        if (ini_get('register_globals'))
        {
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES',);
            foreach ($array as $value)
            {
                foreach ($GLOBALS[$value] as $key => $var)
                {
                    if ($var === $GLOBALS[$key])
                    {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }
}