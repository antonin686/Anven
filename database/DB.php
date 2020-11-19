<?php
namespace database;

class DB
{
    protected $conn;

    public function __construct()
    {
        $servername = trim(getenv("DB_HOST"));
        $username = trim(getenv("DB_USERNAME"));
        $password = trim(getenv("DB_PASSWORD"));
        $dbname = trim(getenv("DB_DATABASE"));

        $this->conn = new \mysqli($servername, $username, $password, $dbname);
    }

    public function getConn()
    {
        return $this->conn;
    }
}
