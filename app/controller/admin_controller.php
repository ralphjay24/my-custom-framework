<?php

class Admin extends Controller
{
    public function __construct($controller,$action)
    {
        parent::__construct($controller, $action);
        $this->_load_model('Users');
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
        if (!empty($session_user) && $session_user['type'] == 'admin')
        {
            $users = $this->_get_model('Users')->display_all();
            if (is_array($users))
            {
                $this->_get_view()->set('users', $users);
            }
            else
            {
                $this->_get_view()->set('error', $users);
            }
            $this->_get_view()->make('admin/homepage');
        }
        else
        {
            header('Location: ../user/login_page');
        }
    }

    public function edit_user_page($id)
    {
        $session_user = $this->_session->get('user');
        if (!empty($session_user) && $session_user['type'] == 'admin')
        {
            if (empty($id))
            {
                header('Location: ../');
            }
            else
            {
                $edit = $this->_get_model('Users')->get($id);
                if ($edit['type'] == 'admin')
                {
                    $edit['admin'] = 'checked="checked"';
                }
                elseif ($edit['type'] == 'user')
                {
                    $edit['user'] = 'checked="checked"';
                }
                $this->_get_view()->set('edit', $edit);
                $this->_get_view()->make('admin/edit_user');
            }
        }
        else
        {
            header('Location: ../');
        }
    }

    public function edit_user($id)
    {
        $session_user = $this->_session->get('user');
        if (!empty($session_user) && $session_user['type'] == 'admin')
        {
            if ($_POST)//checking if the users submit the form
            {
                $admin_password = md5($_POST['password']);
                $post_values = $_POST;
                $post_values['id'] = $id;
                $valid = true;
                if (empty($post_values['first_name']))
                {
                    $fname_error = 'First Name is required.';
                    $valid = false;
                }
                else
                {
                    $fname = $this->_test_input($post_values['first_name']);
                    // check if name only contains letters and whitespace
                    if (!preg_match("/^[a-zA-Z ]*$/",$fname))
                    {
                        $fname_error = 'Only letters and white space allowed.';
                        $valid = false;
                    }
                }
                if (empty($post_values['last_name']))
                {
                    $lname_error = 'Last Name is required.';
                    $valid = false;
                }
                else
                {
                    $lname = $this->_test_input($post_values['last_name']);
                    // check if name only contains letters and whitespace
                    if (!preg_match("/^[a-zA-Z ]*$/",$lname))
                    {
                        $lname_error = 'Only letters and white space allowed.';
                        $valid = false;
                    }
                }
                if (empty($post_values['email_address']))
                {
                    $email_error = 'Email Address is required';
                    $valid = false;
                }
                else
                {
                    $email = $this->_test_input($post_values['email_address']);
                    // check if e-mail address is well-formed
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
                    {
                        $email_error = 'Please enter a valid email address.';
                        $valid = false;
                    }
                }
                if (empty($post_values['password']))
                {
                    $pass_error = 'Password is required.';
                    $valid = false;
                }
                if ($session_user['password'] == $admin_password && $valid == true)
                {
                    unset($post_values['password']);
                    if (!empty($post_values['type']))
                    {
                        if ($post_values['type'] == 'admin')
                        {
                            $post_values['admin'] = 'checked="checked"';
                        }
                        elseif ($post_values['type'] == 'user')
                        {
                            $post_values['user'] = 'checked="checked"';
                        }
                    }
                    else
                    {
                        $post_values['type'] = $session_user['type'];
                    }
                    $edit_user = $this->_get_model('Users')->edit($id, $post_values);
                    $error = $edit_user;
                    if ($error === true)
                    {
                        $_SESSION['user']['first_name'] = $post_values['first_name'];
                        $_SESSION['user']['middle_name'] = $post_values['middle_name'];
                        $_SESSION['user']['last_name'] = $post_values['last_name'];
                        $_SESSION['user']['address'] = $post_values['address'];
                        $_SESSION['user']['contact_number'] = $post_values['contact_number'];
                        $_SESSION['user']['email_address'] = $post_values['email_address'];
                        $error = '<div class="alert alert-success fade in">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Successfully</strong> Updated.
                                   </div>';
                    }
                    elseif ($error == 'id')
                    {
                        $error = '<div class="alert alert-warning fade in">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>User</strong> doesn\'t exists.
                                   </div>';
                    }
                    else
                    {
                        $error = '<div class="alert alert-danger fade in">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Something went wrong.</strong> Can\'t register.
                                   </div>';
                    }
                }
                else
                {
                    if ($post_values['type'] == 'admin')
                    {
                        $post_values['admin'] = 'checked="checked"';
                    }
                    elseif ($post_values['type'] == 'user')
                    {
                        $post_values['user'] = 'checked="checked"';
                    }
                    $error = 'You are not authorized to edit this user. Please use admin password. <i>If you are an admin.</i>';
                    $error = '<div class="alert alert-danger fade in">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Error!</strong> ' . $error . '
                                   </div>';
                }
                $this->_get_view()->set('error', $error);
                $this->_get_view()->set('fname_error', $fname_error);
                $this->_get_view()->set('lname_error', $lname_error);
                $this->_get_view()->set('email_error', $email_error);
                $this->_get_view()->set('pass_error', $pass_error);
                $this->_get_view()->set('edit', $post_values);
                $this->_get_view()->make('admin/edit_user');
            }
            else
            {
                header('Location: ../edit_user_page/' . $id);
            }
        }
        else
        {
            header('Location: ../');
        }
    }

    public function delete_user()
    {
        $session_user = $this->_session->get('user');
        if (!empty($session_user) && $session_user['type'] == 'admin')
        {
            if($_POST)
            {
                $id = $_POST['id'];
                if ($session_user['id'] != $id)
                {
                    $this->_get_model('Users')->remove($id);
                }
                header('Location: ../admin/');
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