<?php

class Database
{
    private $__connection;

    public function __construct()
    {
        try
        {
            $this->__connection = new PDO ("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
            $this->__connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOExeption $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     *   insert() = method for inserting data to the database using prepared statement
     *   $table       string
     *   $values      array
     *   $columns     array
     */
    public function insert($table, $values, $columns)
    {
        $query = '';
        $col_string = '';
        $vals_counter = 0;


        if (!$columns)
        {
            $col_string = ''; //empty string for generic inserts....
        }
        else
        {
            $col_string = $this->__column_parser($columns);
        }

        $query = 'INSERT INTO ' . $table . ' ' . $col_string . ' VALUES (';

        foreach ($values as $value)
        {
            $query .= '?';
            if($vals_counter <= (count($values)-2))
                $query .= ',';

            $vals_counter++;
        }

        $query .= ');';

        try
        {
            $this->statement = $this->__connection->prepare($query);
            $this->statement->execute($values);
            $result = $this->statement->rowCount();
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }

        return $result;
    }


    /**
     *  select() = method for getting the data to the database using prepared statement.
     *  $table          string
     *  $columns        array
     *  $conditions     array('column_name'=>'value', 'condtion_symbol'=>'value', 'value'=>'value', {'condtion_clause'=>'value'})
     *  $order_by       array('column_name'=>'value', 'order_type'=>'value')
     */
    public function select($table, $columns, $conditions = null, $order_by = null)
    {
        $query = '';
        $query .= $this->__select($columns);
        $query .= 'FROM ' . $table;

        if (isset($conditions))
        {
            $query .= $this->__where_conditions($conditions);
            $values = $this->__get_values($conditions);
        }
        if (isset($order_by))
        {
            $query .= $this->__order_by($order_by);
        }

        try
        {
            $result = $this->__connection->prepare($query);
            $result->execute($values);
            $results = $result->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }

        return $results;
    }

    /**
     *  update() = method for updating data to the database using prepared statement.
     *  $table          string
     *  $updates        array
     *  $condition      array('column_name'=>'value', 'condtion_symbol'=>'value', 'value'=>'value', {'condtion_clause'=>'value'})
     */
    public function update($table, $updates, $condition = null)
    {
        $query = '';
        $query .= 'UPDATE ' . $table;
        $query .= $this->__set_update($updates);


        if (isset($condition))
        {
            $values = $this->__get_values(array($condition));
            $query .= $this->__where_conditions(array($condition));
        }

        try
        {
            $this->statement = $this->__connection->prepare($query);
            $this->statement->execute($values);
            $result = $this->statement->rowCount();
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }

        return $result;
    }

    /**
     *  delete() = method for deleting the data to the database using prepared statement.
     *  $table          string
     *  $conditions     array('column_name'=>'value', 'condtion_symbol'=>'value', 'value'=>'value', {'condtion_clause'=>'value'})
     */
    public function delete($table, $conditions)
    {
        $query = '';
        $query .= 'DELETE FROM ' . $table;
        if (isset($conditions))
        {
            $query .= $this->__where_conditions_for_delete($conditions);
        }

        try
        {
            $this->statement = $this->__connection->prepare($query);
            $this->statement->execute();
            $result = $this->statement->rowCount();
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }

        return $result;
    }

    /**
     *   free_query() = method for directly input the query string in MySQL
     *   $string_query      string
     */
    public function free_query($string_query)
    {
        try
        {
            $this->statement = $this->__connection->prepare($query);
            $this->statement->execute();
            if (strpos($string_query, 'SELECT') !== false)
            {
                $result = $result->fetchAll(PDO::FETCH_ASSOC);
            }
            else
            {
                $result = $this->statement->rowCount();
            }
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }

        return $result;
    }

    /**
     *   column_parser() = privated method for parsing the column names to the insert query
     *   $columns     array
     */
    private function __column_parser($columns)
    {
        $col_string = "(";
        $cols_counter = 0;

        foreach ($columns as $column)
        {
            $col_string .= $column;
            if ($cols_counter <= (count($columns)-2))
                $col_string .= ",";

            $cols_counter++;
        }

        $col_string .= ")";

        return $col_string;
    }

    private function __select($columns)
    {
        $string_query = 'SELECT ';
        $cols_counter = 0;

        foreach ($columns as $cols)
        {
            $string_query .= $cols;
            if ($cols_counter <= (count($columns)-2))
            {
                $string_query .= ', ';
            }
            $cols_counter++;
        }

        $string_query .= ' ';
        return $string_query;
    }

    private function __where_conditions($conditions)
    {
        $string_query = ' WHERE ';
        foreach ($conditions as $cons)
        {
            $string_query .= $cons['column_name'] . ' ' . $cons['condition_symbol'] . ' ?';

            if (isset($cons['condition_clause']))
            {
                $string_query .= ' ' . $cons['condition_clause'] . ' ';
            }
        }

        $string_query .= '';
        return $string_query;
    }

    private function __order_by($order)
    {
        $string_query = ' ORDER BY ';
        $order_counter = 0;

        foreach($order as $orders)
        {
            $string_query .= $orders['column_name'];
            if(isset($orders['order_type']))
            {
                $string_query .= ' ' . $orders['order_type'];
            }

            if ($order_counter <= (count($order)-2))
            {
                $string_query .= ', ';
            }
            $order_counter++;
        }

        return $string_query;
    }

    private function __get_values($conditions)
    {
        $array_values = array();

        foreach ($conditions as $cons)
        {
            array_push($array_values, $cons['value']);
        }

        return $array_values;
    }

    private function __set_update($updates)
    {
        $string_query = ' SET ';
        $ups_counter = 0;

        foreach ($updates as $ups)
        {
            $string_query .= $ups['column_name'] . ' = \'' . $ups['value'] . '\'';
            if ($ups_counter <= (count($updates)-2))
            {
                $string_query .= ', ';
            }
            $ups_counter++;
        }
        return $string_query;
    }

    private function __where_conditions_for_delete($conditions)
    {
        $string_query = ' WHERE ';
        foreach ($conditions as $cons)
        {
            $string_query .= $cons['column_name'] . ' = ' . $cons['value'];
            if (isset($cons['condition_clause']))
            {
                $string_query .= ' ' . $cons['condition_clause'] . ' ';
            }
        }
        $string_query .= ';';
        return $string_query;
    }



}

