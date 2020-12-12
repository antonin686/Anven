<?php

class Route
{
    static $routes = [];
    static $buffer = [];

    public static function get($url, $action)
    {
        $action = explode('>', $action);
        $url = "GET-/api" . $url;
        //print_r($action);
        self::$buffer[$url] = (object) [
            'type' => 'get',
            'controller' => $action[0],
            'method' => isset($action[1]) ? $action[1] : null,
            'request' => null,
            'middleware' => null
        ];
    }

    public static function post($url, $action)
    {
        $action = explode('>', $action);
        $url = "POST-/api" . $url;
        //print_r($action);
        $req = (object) $_POST;
        self::$buffer[$url] = (object) [
            'type' => 'post',
            'controller' => $action[0],
            'method' => isset($action[1]) ? $action[1] : null,
            'request' => $req,
            'middleware' => null
        ];
    }

    public static function middleware($args, $func)
    {
        self::clearBuffer();
        $func();
        foreach (self::$buffer as $key => $route) {
            $route->middlewares = $args;
        }
        self::clearBuffer();
    }

    public static function getRoutes()
    {
        return self::$routes;
    }

    public static function match($url)
    {
        if (isset(self::$routes[$url])) {
            return self::$routes[$url];
        } else {
            return false;
        }
    }

    public static function clearBuffer()
    {
        if (!empty(self::$buffer)) {
            self::$routes = array_merge(self::$routes, self::$buffer);
        }
        self::$buffer = [];
    }
}
