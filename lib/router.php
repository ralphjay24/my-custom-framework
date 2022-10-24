<?php

class Router
{
    public function route($url)
    {
        // Split the URL into parts
        $url_array = array();
        $url_array = explode("/", $url);
        // The first part of the URL is the controller name
        $controller = isset($url_array[0]) ? $url_array[0] : ''; array_shift($url_array);
        // The second part is the method name
        $method = isset($url_array[0]) ? $url_array[0] : ''; array_shift($url_array);
        // The third part are the parameters
        $query_string = $url_array;
        // if controller is empty, redirect to default controller
        if (empty($controller))
        {
            $controller = DEFAULT_CONTROLLER;
        }
        // if method is empty, redirect to index page
        if (empty($method))
        {
            $method = DEFAULT_METHOD;
        }
        $controller_name = $controller;
        $controller = ucwords($controller);
        $dispatch = new $controller($controller_name, $method);
        if ((int)method_exists($controller, $method))
        {
            call_user_func_array(array($dispatch, $method,), $query_string);
        }
        else
        {
            echo 'Error 404: Route request not found.';
        }
    }
}