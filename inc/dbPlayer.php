<?php
/**
 * Created by PhpStorm.
 * User: troot
 * Date: 1/1/15
 * Time: 10:55 PM
 */

namespace dbPlayer;

class dbPlayer {

    private $db_host="localhost";
    private $db_name="hms";
    private $db_user="root";
    private $db_pass="";
    protected $con;

    public function open(){
        $this->con = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        if($this->con)
        {
            return true;
        }
        else
        {
            return mysqli_connect_error();
        }
    }

    public function close()
    {
        $res = mysqli_close($this->con);
        if($res)
        {
            return true;
        }
        else
        {
            return mysqli_error($this->con);
        }
    }

    public function insertData($table, $data)
    {
        $keys = "`" . implode("`, `", array_keys($data)) . "`";
        $values = "'" . implode("', '", $data) . "'";
        $query = "INSERT INTO `$table` ($keys) VALUES ($values)";
        mysqli_query($this->con, $query);
        return mysqli_insert_id($this->con) . mysqli_error($this->con);
    }

    public function registration($query, $query2)
    {
        $res = mysqli_query($this->con, $query);
        if($res)
        {
            $res = mysqli_query($this->con, $query2);
            if($res)
            {
                return true;
            }
            else
            {
                return mysqli_error($this->con);
            }
        }
        else
        {
            return mysqli_error($this->con);
        }
    }

    public function getData($query)
    {
        $res = mysqli_query($this->con, $query);
        if(!$res)
        {
            return "Can't get data " . mysqli_error($this->con);
        }
        else
        {
            return $res;
        }
    }

    public function update($query)
    {
        $res = mysqli_query($this->con, $query);
        if(!$res)
        {
            return "Can't update data " . mysqli_error($this->con);
        }
        else
        {
            return true;
        }
    }

    public function updateData($table, $conColumn, $conValue, $data)
    {
        $updates = array();
        if (count($data) > 0) {
            foreach ($data as $key => $value) {
                $value = mysqli_real_escape_string($this->con, $value);
                $value = "'$value'";
                $updates[] = "$key = $value";
            }
        }
        $implodeArray = implode(', ', $updates);
        $query = "UPDATE $table SET $implodeArray WHERE $conColumn = '$conValue'";
        $res = mysqli_query($this->con, $query);
        if(!$res)
        {
            return "Can't Update data " . mysqli_error($this->con);
        }
        else
        {
            return true;
        }
    }

    public function delete($query)
    {
        $res = mysqli_query($this->con, $query);
        if(!$res)
        {
            return "Can't delete data " . mysqli_error($this->con);
        }
        else
        {
            return true;
        }
    }
}
   
