<?php

class Contact extends Controller
{
    public function __construct($controller,$action)
    {
        parent::__construct($controller, $action);
        $this->_load_model('Contacts');
    }

    private function _test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function index()
    {
        $session_user = $this->_session->get('user');
        if (!empty($session_user) && $session_user['type'] == 'user')
        {
            $contacts = $this->_get_model('Contacts')->display_per_user($session_user['id']);
            if (is_array($contacts))
            {
                $this->_get_view()->set('contacts', $contacts);
            }
            else
            {
                $this->_get_view()->set('error', $contacts);
            }
            $this->_get_view()->make('contact/contacts');
        }
        else
        {
            header('Location: ../user/login_page');
        }
    }

    public function add_page()
    {
        $session_user = $this->_session->get('user');
        if (!empty($session_user) && $session_user['type'] == 'user')
        {
            $this->_get_view()->make('contact/add');
        }
        else
        {
            header('Location: ../user/login_page');
        }
    }

    public function add()
    {
        $session_user = $this->_session->get('user');
        if (!empty($session_user) && $session_user['type'] == 'user')
        {
            if ($_POST)//checking if the users submit the form
            {
                $post_values = $_POST;
                $valid = true;
                $post_values['user_id'] = $session_user['id'];
                if (empty($post_values['name']))
                {
                    $name_error = 'Name is required.';
                    $valid = false;
                }
                else
                {
                    $name = $this->_test_input($post_values['name']);
                    // check if name only contains letters and whitespace
                    if (!preg_match("/^[a-zA-Z ]*$/",$name))
                    {
                        $name_error = 'Only letters and white space allowed.';
                        $valid = false;
                    }
                }
                if ($valid == true)
                {
                    $error = $this->_get_model('Contacts')->add($post_values);
                    if ($error === true)
                    {
                        $error = '<div class="alert alert-success fade in">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Successfully</strong> Added.
                                   </div>';
                    }
                    else
                    {
                        $error = '<div class="alert alert-danger fade in">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Something went wrong.</strong> Can\'t add the contact. Contact the web admin.
                                   </div>';
                    }
                }
                $this->_get_view()->set('error', $error);
                $this->_get_view()->set('name_error', $name_error);
                $this->_get_view()->make('contact/add');
            }
            else
            {
                //$this->router()->route('user/signup_page');
                header('Location: ./add_page');
            }
        }
        else
        {
            header('Location: ../user/login_page');
        }
    }

    public function edit_page($id)
    {
        $session_user = $this->_session->get('user');
        if (!empty($session_user) && $session_user['type'] == 'user')
        {
            if (empty($id))
            {
                header('Location: ../');
            }
            else
            {
                $check = $this->_get_model('Contacts')->of_user($id);
                if ($session_user['id'] == $check)
                {
                        $edit = $this->_get_model('Contacts')->get($id);
                        $this->_get_view()->set('edit', $edit);
                        $this->_get_view()->make('contact/edit');
                }
                else
                {
                    header('Location: ../');
                }
            }
        }
        else
        {
            header('Location: login_page');
        }
    }

    public function edit($id)
    {
        $session_user = $this->_session->get('user');
        if (!empty($session_user) && $session_user['type'] == 'user')
        {
            $check = $this->_get_model('Contacts')->of_user($id);
            if ($session_user['id'] == $check)
            {
                if ($_POST)//checking if the users submit the form
                {
                    $post_values = $_POST;
                    $post_values['id'] = $id;
                    $valid = true;
                    if (empty($post_values['name']))
                    {
                        $name_error = 'Name is required.';
                        $valid = false;
                    }
                    else
                    {
                        $name = $this->_test_input($post_values['name']);
                        // check if name only contains letters and whitespace
                        if (!preg_match("/^[a-zA-Z ]*$/",$name))
                        {
                            $name_error = 'Only letters and white space allowed.';
                            $valid = false;
                        }
                    }
                    if ($valid == true)
                    {

                        $edit_contact = $this->_get_model('Contacts')->edit($id, $post_values);
                        $error = $edit_contact;
                        if ($error === true)
                        {
                            $error = '<div class="alert alert-success fade in">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong>Successfully</strong> Updated.
                                       </div>';
                        }
                        else
                        {
                            $error = '<div class="alert alert-danger fade in">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong>Something went wrong.</strong> Can\'t change your password. Contact the web admin.
                                       </div>';
                        }
                    }

                    $this->_get_view()->set('error', $error);
                    $this->_get_view()->set('name_error', $name_error);
                    $this->_get_view()->set('edit', $post_values);
                    $this->_get_view()->make('contact/edit');
                }
                else
                {
                    header('Location: edit_page/' . $id);
                }
            }
            else
            {
                header('Location: ../');
            }
        }
        else
        {
            header('Location: login_page');
        }
    }

    public function delete()
    {
        $session_user = $this->_session->get('user');
        if (!empty($session_user) && $session_user['type'] == 'user')
        {
            if($_POST)
            {
                $id = $_POST['id'];
                $this->_get_model('Contacts')->delete($id);
                header('Location: ../contact/');
            }
            else
            {
                header('Location: ../');
            }
        }
        else
        {
            header('Location: ../');
        }
    }

}