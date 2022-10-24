<?php
// Load configuration
require_once(ROOT . DS . 'config' . DS . 'config.php');

// Autoload classes
spl_autoload_register(function ($class_name)
{
    if (file_exists(ROOT . DS . 'lib' . DS . strtolower($class_name) . '.php'))
    {
        require_once(ROOT . DS . 'lib' . DS . strtolower($class_name) . '.php');
    }
    elseif (file_exists(ROOT . DS . 'app' . DS . 'controller' . DS . strtolower($class_name) . '_controller.php'))
    {
        require_once(ROOT . DS . 'app' . DS . 'controller' . DS . strtolower($class_name) . '_controller.php');
    }
    elseif (file_exists(ROOT . DS . 'app' . DS . 'model' . DS . strtolower($class_name) . '.php'))
    {
        require_once(ROOT . DS . 'app' . DS . 'model' . DS . strtolower($class_name) . '.php');
    }
});

//Parse the requested url and redirect
Router::route($page);
