<?php

class Contacts extends Database
{
    private $__table = 'contacts';

    public function __construct()
    {
        parent::__construct();
    }

    public function display_per_user($id)
    {
        if($this->__if_user_exists_id($id))
        {
            $condition = array('column_name' => 'user_id', 'condition_symbol' => '=', 'value' => $id, 'condition_clause' => 'AND',);
            $deleted_flag = array('column_name' => 'deleted_flag', 'condition_symbol' => '=', 'value' => 0,);
            $contacts =  $this->select($this->__table, array('id', 'name', 'address', 'phone_number'), array($condition, $deleted_flag, ), array(array('column_name' => 'created_at', 'order_type' => 'DESC',),));
            if (!empty($contacts))
            {
                return $contacts;
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

    public function add($post_values)
    {
        if (!empty($post_values))
        {
            $today = date('Y:m:d H:i:s');
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
            return 'empty';
        }
    }

    public function edit($id, $post_values)
    {
        if ($this->__if_exists($id))
        {
            extract($post_values);
            $today = date('Y:m:d H:i:s');
            $condition = array('column_name' => 'id', 'condition_symbol' => '=', 'value' => $id,);
            $name = array('column_name' => 'name','value' => $name,);
            $address = array('column_name' => 'address','value' => $address,);
            $phone_number = array('column_name' => 'phone_number','value' => $phone_number,);
            $updated_at = array('column_name' => 'update_at','value' => $today,);
            $updates = array($name, $address, $phone_number, $updated_at,);
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

    public function delete($id)
    {
        if ($this->__if_exists($id))
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

    public function of_user($id)
    {
        if($this->__if_exists($id))
        {
            $condition = array('column_name' => 'id', 'condition_symbol' => '=', 'value' => $id, 'condition_clause' => 'AND');
            $deleted_flag = array('column_name' => 'deleted_flag', 'condition_symbol' => '=', 'value' => 0,);
            $user = $this->select($this->__table, array('user_id',), array($condition, $deleted_flag));
            if (!empty($user[0]['user_id']))
            {
                return $user[0]['user_id'];
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

    public function get($id)
    {
        if ($this->__if_exists($id))
        {
            $condition = array('column_name' => 'id', 'condition_symbol' => '=', 'value' => $id,);
            $contact = $this->select($this->__table, array('*',), array($condition));
            if (!empty($contact))
            {
                return $contact[0];
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

    private function __if_user_exists_id($id)
    {
        $condition = array('column_name' => 'id', 'condition_symbol' => '=', 'value' => $id,);
        $user = $this->select('users', array('*',), array($condition));
        if (!empty($user))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function __if_exists($id)
    {
        $condition = array('column_name' => 'id', 'condition_symbol' => '=', 'value' => $id,);
        $contact = $this->select($this->__table, array('*',), array($condition));
        if (!empty($contact))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}