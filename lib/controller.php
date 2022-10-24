<?php

class Controller extends Application
{
    protected $_controller;
    protected $_action;
    protected $_models;
    protected $_view;
    protected $_session;
    protected $_router;

    public function __construct($controller, $action)
    {
        parent::__construct();
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_view = new View();
        $this->_session = new Session();
        $this->_router = new Router();
    }

    // Load model class
    protected function _load_model($model)
    {
        if(class_exists($model))
        {
            $this->_models[$model] = new $model();
        }
    }

    // Get the instance of the loaded model class
    protected function _get_model($model)
    {
        if (is_object($this->_models[$model]))
        {
            return $this->_models[$model];
        }
        else
        {
            return false;
        }
    }

    // Return view object
    protected function _get_view()
    {
        return $this->_view;
    }

    // Return session object
    protected function _session()
    {
        return $this->_session;
    }

    // Return router object
    protected function router()
    {
        return $this->_router;
    }
}