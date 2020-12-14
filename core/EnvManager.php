<?php
namespace core;

class EnvManager
{
    public function __construct()
    {
        $myfile = fopen( __DIR__ ."/../.env", "r") or die("Unable to open file!");
        while (!feof($myfile)) {
            $line = fgets($myfile);
            putenv($line);
        }
        fclose($myfile);
    }
}
