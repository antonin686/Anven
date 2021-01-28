<?php
namespace database;

use database\DB;

class Model
{
    protected static $table_name;
    protected $conn;

    public static function table_name()
    {
        return static::$table_name;
    }

    public static function find($id)
    {
        $conn = DB::getConn();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM " . static::$table_name . " WHERE id = {$id}";

        $result = $conn->query($sql);

        //return $result;
        if ($result) {
            return $result->fetch_object();
        } else {
            echo "0 results";
        }

        $conn->close();
    }

    public function all()
    {
        $conn = DB::getConn();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM " . static::$table_name;

        $result = $conn->query($sql);

        //echo $result;
        //var_dump(count($result->fetch_array()));

        if ($result = $result->fetch_all(MYSQLI_ASSOC)) {
            $res = json_decode(json_encode($result), false);
            
            return $res;
        } else {
            return null;
        }

        $conn->close();
    }

    public function create($datas)
    {
        $conn = DB::getConn();

        $columns = $values = " ";
        foreach ($datas as $key => $value) {
            $columns .= $key . ", ";
            $values .= "'" . $value . "', ";
        }

        $columns = rtrim(trim($columns), ',');
        $values = rtrim(trim($values), ',');

        $sql = "INSERT INTO " . static::$table_name . " ( {$columns} ) values ( {$values} ) ;";

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($conn->query($sql) === true) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

    public function update($id, $datas)
    {
        $conn = DB::getConn();

        $sql = "UPDATE " . static::$table_name . " SET ";
        foreach ($datas as $column => $value) {
            $sql .= "{$column} = '{$value}', ";
        }
        $sql = rtrim(trim($sql), ',');
        $sql .= " where id = {$id}";
        //echo $sql;

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($conn->query($sql) === true) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

    public function delete($id)
    {
        $conn = DB::getConn();

        $sql = "DELETE FROM " . static::$table_name . " WHERE id = {$id}";

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($conn->query($sql) === true) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }

}
