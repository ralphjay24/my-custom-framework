<?php

class View
{
    protected $_variables = array();

    public function set($name, $value)
    {
        $this->_variables[$name] = $value;
    }

    public function make($view_name)
    {
        extract($this->_variables);
        if (file_exists(ROOT . DS . 'app' . DS . 'view' . DS . $view_name . '.php'))
        {
            include (ROOT . DS . 'app' . DS . 'view' . DS . $view_name . '.php');
        }
        else
        {
            echo 'Error 404: Page request not found.';
        }
    }
}