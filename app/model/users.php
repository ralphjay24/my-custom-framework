<?php

class Users extends Database
{
    private $__table = 'users';

    public function __construct()
    {
        parent::__construct();
    }

    public function display_all()
    {
        $users =  $this->select($this->__table, array('*',), null, array(array('column_name' => 'created_at', 'order_type' => 'DESC',),));
        if (!empty($users))
        {
            foreach ($users as $key => $value)
            {
                $date_created = date('m/d/Y H:i',strtotime($value['created_at']));
                if (!empty($value['update_at']))
                {
                    $date_updated = date('m/d/Y H:i',strtotime($value['update_at']));
                }
                else
                {
                    $date_updated = 'Not updated yet.';
                }

                if (!empty($value['middle_name']))
                {
                    $full_name = $value['first_name'] . ' ' . $value['middle_name'][0] . '. ' . $value['last_name'];
                }
                else
                {
                    $full_name = $value['first_name'] . ' ' . $value['last_name'];
                }
                $users[$key]['full_name'] = $full_name;
                $users[$key]['created_at'] = $date_created;
                $users[$key]['update_at'] = $date_updated;
                if ($value['deleted_flag'] == 1)
                {
                    unset($users[$key]);
                }
            }
            return $users;
        }
        else
        {
            return false;
        }
    }

    public function edit($id, $post_values)
    {
        if ($this->__if_exists_id($id))
        {
            extract($post_values);
            $today = date('Y:m:d H:i:s');
            $condition = array('column_name' => 'id', 'condition_symbol' => '=', 'value' => $id,);
            $first_name = array('column_name' => 'first_name','value' => $first_name,);
            $middle_name = array('column_name' => 'middle_name','value' => $middle_name,);
            $last_name = array('column_name' => 'last_name','value' => $last_name,);
            $address = array('column_name' => 'address','value' => $address,);
            $contact_number = array('column_name' => 'contact_number','value' => $contact_number,);
            //$password = array('column_name' => 'password','value' => md5($password),);
            $type = array('column_name' => 'type','value' => $type,);
            $updated_at = array('column_name' => 'update_at','value' => $today,);
            $updates = array($first_name, $middle_name, $last_name, $address, $contact_number, $type, $updated_at);
            $update = $this->update($this->__table, $updates, $condition);
            if ($update)
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
            return 'id';
        }
    }

    public function change_pass($id, $password)
    {
        if ($this->__if_exists_id($id))
        {
            extract($post_values);
            $today = date('Y:m:d H:i:s');
            $condition = array('column_name' => 'id', 'condition_symbol' => '=', 'value' => $id,);
            $password = array('column_name' => 'password','value' => md5($password),);
            $updated_at = array('column_name' => 'update_at','value' => $today,);
            $updates = array($password, $updated_at,);
            $update = $this->update($this->__table, $updates, $condition);
            if ($update)
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
            return 'id';
        }
    }

    public function remove($id)
    {
        if ($this->__if_exists_id($id))
        {
            $today = date('Y:m:d H:i:s');
            $delete_flag = array('column_name' => 'deleted_flag','value' => 1,);
            $updated_at = array('column_name' => 'update_at','value' => $today,);
            $condition = array('column_name' => 'id','condition_symbol' => '=','value' => $id,);
            $user = $this->update($this->__table, array($delete_flag, $updated_at,), $condition);
            return $user;
        }
        else
        {
            return false;
        }
    }

    public function get($id)
    {
        if ($this->__if_exists_id($id))
        {
            $condition = array('column_name' => 'id', 'condition_symbol' => '=', 'value' => $id,);
            $user = $this->select($this->__table, array('*',), array($condition));
            if (!empty($user))
            {
                return $user[0];
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
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

    private function __get_password($id)
    {
        $condition = array('column_name' => 'id', 'condition_symbol' => '=', 'value' => $id,);
        $user = $this->select($this->__table, array('*',), array($condition));
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