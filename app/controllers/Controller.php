<?php

namespace app\controllers;

class Controller
{
    public static function json($obj)
    {
        return json_encode($obj);
    }
}
