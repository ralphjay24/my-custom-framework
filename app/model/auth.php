<?php

class Auth extends Database
{
    private $__table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public function register($post_values)
    {
        $email_exist = $this->__if_exists($post_values['email_address']);
        $if_delete = $this->__if_deleted($post_values['email_address']);
        if ($if_delete)
        {
            if (!$email_exist)
            {
                $today = date('Y:m:d H:i:s');
                $post_values['password'] = md5($post_values['password']);
                $post_values['created_at'] = $today;
                $values = array_values($post_values);
                $columns = array_keys($post_values);
                $insert = $this->insert($this->__table, $values, $columns);
                if ($insert)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return 'exist';
            }
        }
    }

    public function login($email, $password)
    {
        $con_email = array('column_name' => 'email_address', 'condition_symbol' =>' =', 'value' => $email, 'condition_clause' => 'AND',);
        $con_password = array('column_name' => 'password', 'condition_symbol' => '=', 'value' => md5($password), 'condition_clause' => 'AND',);
        $deleted_flag = array('column_name' => 'deleted_flag', 'condition_symbol' => '=', 'value' => 0,);
        $user = $this->select($this->__table, array('*',), array($con_email, $con_password, $deleted_flag,));
        $count = 0;
        if ($this->__if_exists($email) || $this->__if_deleted($email))
        {
            if ($this->__get_password($email) == md5($password))
            {
                if (!empty($user))
                {
                    return $user[$count];
                }
                else
                {
                    return 'Your account has been deleted in our database. Please contact the web admin.';
                }
            }
            else
            {
                return 'Please input your password correctly.';
            }
        }
        else
        {
            return 'No ' . $email . ' account is stored in our database. Please go to our <a href="signup">signup page</a> for your registration.';
        }
    }

    private function __if_exists($email)
    {
        $condition = array('column_name' => 'email_address', 'condition_symbol' => '=', 'value' => $email, 'condition_clause' => 'AND',);
        $deleted_flag = array('column_name' => 'deleted_flag', 'condition_symbol' => '=', 'value' => 0,);
        $user = $this->select($this->__table, array('*',), array($condition, $deleted_flag,));
        if (!empty($user))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function __if_deleted($email)
    {
        $condition = array('column_name' => 'email_address', 'condition_symbol' => '=', 'value' => $email, 'condition_clause' => 'AND',);
        $deleted_flag = array('column_name' => 'deleted_flag', 'condition_symbol' => '=', 'value' => 1,);
        $user = $this->select($this->__table, array('*',), array($condition, $deleted_flag,));
        if (!empty($user))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function __if_exists_id($id)
    {
        $condition = array('column_name' => 'id', 'condition_symbol' => '=', 'value' => $id,);
        $user = $this->select($this->__table, array('*',), array($condition));
        if (!empty($user))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function __get_password($email)
    {
        $condition = array('column_name' => 'email_address', 'condition_symbol' => '=', 'value' => $email, 'condition_clause' => 'AND',);
        $deleted_flag = array('column_name' => 'deleted_flag', 'condition_symbol' => '=', 'value' => 0,);
        $user = $this->select($this->__table, array('*',), array($condition, $deleted_flag, ));
        if (!empty($user))
        {
            return $user[0]['password'];
        }
        else
        {
            return false;
        }
    }
}