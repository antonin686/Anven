<?php
namespace database;

class Result
{
    private $obj;

    public function __construct($obj) 
    {
        $this->obj = $obj;
    }

    public function first() {
        return $this->obj[0];
    }

    public function get() {
        return $this->obj;
    }
}