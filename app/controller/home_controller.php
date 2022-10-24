<?php

class Home extends Controller
{
    public function __construct($controller,$action)
    {
        parent::__construct($controller, $action);
    }

    public function index()
    {
        /*$this->_session()->set('user', array('name' => 'Ralph',));
        print_r($this->_session->get('user'));
        $this->_session()->destroy();
        print_r($_SESSION);
        echo $id;*/
        // $this->_get_view()->make('home');
        header('Location: user/login_page');
    }

    public function search($id)
    {
        $this->_session()->set('user', array('name' => 'Ralph',));
        print_r($this->_session->get('user'));
        $this->_session()->destroy();
        print_r($_SESSION);
        if(isset($id))
        {
            echo 'Id found.';
        }
        else
        {
            echo 'Id not found.';
        }
        //$this->_get_view()->make('home');
    }
}