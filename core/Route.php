<?php

class Route
{
    static $routes = [];

    public static function get($url, $action)
    {
        $action = explode('>', $action);
        $url = "/api" . $url;
        //print_r($action);
        self::$routes[$url] = (object) [
            'type' => 'get',
            'controller' => $action[0],
            'method' => isset($action[1]) ? $action[1] : null,
        ];
    }

    public static function post($url, $action)
    {
        $action = explode('>', $action);
        $url = "/api" . $url;
        //print_r($action);
        $req = (object) $_POST;
        self::$routes[$url] = (object) [
            'type' => 'post',
            'controller' => $action[0],
            'method' => isset($action[1]) ? $action[1] : null,
            'request' => $req,
        ];
    }

    public static function getRoutes()
    {
        var_dump(self::$routes);
    }

    public static function match($url)
    {
        if (isset(self::$routes[$url])) {
            return self::$routes[$url];
        } else {
            return false;
        }
    }
}
