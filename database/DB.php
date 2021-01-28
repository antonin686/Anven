<?php
namespace database;

use database\Result;

class DB
{
    public static function getConn()
    {
        $servername = trim(getenv("DB_HOST"));
        $username = trim(getenv("DB_USERNAME"));
        $password = trim(getenv("DB_PASSWORD"));
        $dbname = trim(getenv("DB_DATABASE"));

        $conn = new \mysqli($servername, $username, $password, $dbname);

        return $conn;
    }

    public static function query($sql)
    {
        $conn = DB::getConn();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $result = $conn->query($sql);

        //echo $result;
        //var_dump(count($result->fetch_array()));

        if ($result = $result->fetch_all(MYSQLI_ASSOC)) {
            $object = json_decode(json_encode($result), false);
            $res = new Result($object);
            
            return $res;
        } else {
            return null;
        }

        $conn->close();
    }

    public static function invoke($sql)
    {
        $conn = DB::getConn();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($conn->query($sql) === true) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
