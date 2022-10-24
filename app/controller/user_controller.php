<?php

class User extends Controller
{
    public function __construct($controller,$action)
    {
        parent::__construct($controller, $action);
        $this->_load_model('Auth');
        $this->_load_model('Users');
    }

    private function _test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function homepage()
    {
        $session_user = $this->_session->get('user');
        if (!empty($session_user) && $session_user['type'] == 'user')
        {
            $date_created = date('F d, Y h:i A',strtotime($session_user['created_at']));
            if (!empty($session_user['update_at']))
            {
                $date_updated = date('F d, Y h:i A',strtotime($session_user['update_at']));
            }
            else
            {
                $date_updated = 'Not updated yet.';
            }

            if (!empty($session_user['middle_name']))
            {
                $full_name = $session_user['first_name'] . ' ' . $session_user['middle_name'][0] . '. ' . $session_user['last_name'];
            }
            else
            {
                $full_name = $session_user['first_name'] . ' ' . $session_user['last_name'];
            }
            $session_user['full_name'] = $full_name;
            $session_user['created_at'] = $date_created;
            $session_user['update_at'] = $date_updated;
            $this->_get_view()->set('user', $session_user);
            $this->_get_view()->make('user/home');
        }
        else
        {
            header('Location: ../user/login_page');
        }
    }

    public function signup_page()
    {
        $session_user = $this->_session->get('user');
        if (!empty($session_user) && $session_user['type'] == 'user')
        {
            header('Location: login_page');
        }
        elseif (!empty($session_user) && $session_user['type'] == 'admin')
        {
            $this->_get_view()->make('auth/signup');
        }
        else
        {
            $this->_get_view()->make('auth/signup');
        }
    }

    public function signup()
    {
        if ($_POST)//checking if the users submit the form
        {
            $post_values = $_POST;
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
            if (empty($post_values['password_confirmation']))
            {
                $cpass_error = 'Password Confirmation is required.';
                $valid = false;
            }
            if ((!empty($post_values['password']) || !empty($post_values['password_confirmation'])) && $valid == true)
            {
                if ($post_values['password'] === $post_values['password_confirmation'])
                {
                    unset($post_values['password_confirmation']);
                    $error = $this->_get_model('Auth')->register($post_values);
                    if ($error === true)
                    {
                        $error = '<div class="alert alert-success fade in">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Successfully</strong> Added.
                                   </div>';
                    }
                    elseif ($error == 'exist')
                    {
                        $error = '<div class="alert alert-warning fade in">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Email Address</strong> exists.
                                   </div>';
                    }
                    else
                    {
                        $error = '<div class="alert alert-danger fade in">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Something went wrong.</strong> Can\'t register. Contact the web admin.
                                   </div>';
                    }
                    /* FOR some important validations for future deployment
                    $password = $this->_test_input($post_values["password"]);
                    $cpassword = $this->_test_input($post_values["password_confirmation"]);
                    if (strlen($post_values['password']) <= '8') {
                        $pass_error = "Your Password Must Contain At Least 8 Characters!";
                    }
                    elseif(!preg_match("#[0-9]+#",$password)) {
                        $pass_error = "Your Password Must Contain At Least 1 Number!";
                    }
                    elseif(!preg_match("#[A-Z]+#",$password)) {
                        $pass_error = "Your Password Must Contain At Least 1 Capital Letter!";
                    }
                    elseif(!preg_match("#[a-z]+#",$password)) {
                        $pass_error = "Your Password Must Contain At Least 1 Lowercase Letter!";
                    }*/
                }
                else
                {
                    $error = 'Confirm password doesn\'t match the password.';
                    $error = '<div class="alert alert-danger fade in">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> ' . $error . '
                               </div>';
                }
            }
            $this->_get_view()->set('error', $error);
            $this->_get_view()->set('fname_error', $fname_error);
            $this->_get_view()->set('lname_error', $lname_error);
            $this->_get_view()->set('email_error', $email_error);
            $this->_get_view()->set('pass_error', $pass_error);
            $this->_get_view()->set('cpass_error', $cpass_error);
            $this->_get_view()->make('auth/signup');
        }
        else
        {
            //$this->router()->route('user/signup_page');
            header('Location: signup_page');
        }

    }

    public function login_page()
    {
        if (!empty($this->_session()->get('user')))
        {
            if ($this->_session()->get('user')['type'] == 'admin')
            {
                header('Location: ../admin/');
            }
            elseif ($this->_session()->get('user')['type'] == 'user')
            {
                header('Location: homepage');
            }
            //$this->router()->route('user/logout');
        }
        else
        {
            $this->_get_view()->make('auth/login');
        }
    }

    public function login()
    {
        if ($_POST)//checking if the users submit the form
        {
            $valid = true;
            $email = $this->_test_input($_POST['email_address']);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $email_error = 'Please enter a valid email address.';
                $valid = false;
            }
            if (!empty($_POST['email_address']) && !empty($_POST['password']))
            {
                if ($valid == true)
                {
                    extract($_POST);
                    $login = $this->_get_model('Auth')->login($email_address, $password);
                    if (is_array($login))
                    {
                        $this->_session()->set('user', $login);
                        if ($login['type'] == 'admin')
                        {
                            //$this->router()->route('admin');
                            header('Location: ../admin/');
                        }
                        elseif ($login['type'] == 'user')
                        {
                            header('Location: homepage');
                        }
                        //print_r($this->_session()->get('user')['email_address']);
                        //exit();
                    }
                    else
                    {
                        $error = $login;
                    }
                }
            }
            else
            {
                $error = 'Please input your email address and password.';
            }
            $this->_get_view()->set('email_error', $email_error);
            $this->_get_view()->set('error', $error);
            $this->_get_view()->make('auth/login');
        }
        else
        {
            //$this->router()->route('user/login_page');
            header('Location: login_page');
        }
    }

    public function logout()
    {
        $this->_session()->destroy();
        header('Location: login_page');
    }

    public function edit_page($id)
    {
        $session_user = $this->_session->get('user');
        if (!empty($session_user) && $session_user['type'] == 'user')
        {
            if (empty($id) || $session_user['id'] != $id)
            {
                header('Location: ../homepage');
            }
            else
            {
                $edit = $this->_get_model('Users')->get($id);
                $this->_get_view()->set('edit', $edit);
                $this->_get_view()->make('user/edit');
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
            if ($session_user['id'] == $id)
            {
                if ($_POST)//checking if the users submit the form
                {
                    $password = md5($_POST['password']);
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
                    if ($session_user['password'] == $password && $valid == true)
                    {
                        unset($post_values['password']);
                        /*if ($post_values['type'] == 'admin')
                        {
                            $post_values['admin'] = 'checked="checked"';
                        }
                        elseif ($post_values['type'] == 'user')
                        {
                            $$post_values['user'] = 'checked="checked"';
                        }*/
                        $post_values['type'] = $session_user['type'];
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
                                            <strong>Something went wrong.</strong> Can\'t register. Contact the web admin.
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
                        $error = 'Wrong password.';
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
                    $this->_get_view()->make('user/edit');
                }
                else
                {
                    header('Location: edit_page/' . $id);
                }
            }
            else
            {
                header('Location: ../homepage');
            }
        }
        else
        {
            header('Location: login_page');
        }
    }

    public function change_pass_page($id)
    {
        $session_user = $this->_session->get('user');
        if (!empty($session_user) && $session_user['type'] == 'user')
        {
            if (empty($id) || $session_user['id'] != $id)
            {
                header('Location: ../homepage');
            }
            else
            {
                // $edit = $this->_get_model('Users')->get($id);
                $this->_get_view()->set('id', $id);
                $this->_get_view()->make('user/change_pass');
            }
        }
        else
        {
            header('Location: login_page');
        }
    }

    public function change_pass($id)
    {
        $session_user = $this->_session->get('user');
        if (!empty($session_user) && $session_user['type'] == 'user')
        {
            if ($session_user['id'] == $id)
            {
                if ($_POST)//checking if the users submit the form
                {
                    $post_values = $_POST;
                    $old_password = md5($post_values['old_password']);
                    $post_values['id'] = $id;
                    $valid = true;
                    if (empty($post_values['old_password']))
                    {
                        $old_error = 'Old Password is required.';
                        $valid = false;
                    }
                    if (empty($post_values['new_password']))
                    {
                        $new_error = 'New Password is required.';
                        $valid = false;
                    }
                    if (empty($post_values['confirm_password']))
                    {
                        $confirm_error = 'Confirm Password is required';
                        $valid = false;
                    }
                    if ($session_user['password'] == $old_password && $valid == true)
                    {
                        if ($post_values['old_password'] != $post_values['new_password'] && $valid == true)
                        {
                            if ($post_values['new_password'] == $post_values['confirm_password'] && $valid == true)
                            {
                                $edit_user = $this->_get_model('Users')->change_pass($id, $post_values['new_password']);
                                $error = $edit_user;
                                if ($error === true)
                                {
                                    $_SESSION['user']['password'] = md5($post_values['new_password']);
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
                                                    <strong>Something went wrong.</strong> Can\'t change your password. Contact the web admin.
                                               </div>';
                                }
                            }
                            else
                            {
                                $error = 'Confirm password doesn\'t match the password.';
                                $error = '<div class="alert alert-danger fade in">
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                    <strong>Error!</strong> ' . $error . '
                                               </div>';
                            }
                        }
                        else
                        {
                            $error = 'No need to change your password.';
                            $error = '<div class="alert alert-success fade in">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong>Psst!</strong> ' . $error . '
                                       </div>';
                        }
                    }
                    else
                    {
                        $error = 'Please input your current password.';
                        $error = '<div class="alert alert-danger fade in">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <strong>Error!</strong> ' . $error . '
                                       </div>';
                    }
                    $this->_get_view()->set('error', $error);
                    $this->_get_view()->set('opass_error', $old_error);
                    $this->_get_view()->set('npass_error', $new_error);
                    $this->_get_view()->set('cpass_error', $confirm_error);
                    $this->_get_view()->set('id', $id);
                    $this->_get_view()->make('user/change_pass');
                }
                else
                {
                    header('Location: change_pass_page/' . $id);
                }
            }
            else
            {
                header('Location: ../homepage');
            }
        }
        else
        {
            header('Location: login_page');
        }
    }
}