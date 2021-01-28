<?php

class Route
{
    static $routes = [];
    static $buffer = [];

    public static function get($url, $action)
    {
        self::addToBuffer("GET", $url, $action);
    }

    public static function post($url, $action)
    {
        self::addToBuffer("POST", $url, $action);
    }

    public static function addToBuffer($type, $url, $action)
    {
        $action = explode('>', $action);
        $url = "/api" . $url;
        $urlSplited = explode("/:", $url);
        $params = false;
        $url = $urlSplited[0];
        $request =  $type == "GET" ? null : (object) $_POST;

        if (!isset($request)) $request = new \stdClass();
        $request->headers = (object) getallheaders();

        if (count($urlSplited) > 1) {
            array_shift($urlSplited);
            $params = $urlSplited;
        }
        //pwb("count: " . count($urlSplited));
        //print_r($action);
        self::$buffer[] = (object) [
            'url' => $url,
            'type' => $type,
            'controller' => $action[0],
            'method' => isset($action[1]) ? $action[1] : null,
            'request' => $request,
            'middlewares' => null,
            'params' => $params,
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

    public static function match($url, $type)
    {    
        foreach (self::$routes as $route) {

            if($route->type == $type) {
                if ($route->url == $url) {
                    return $route;
                }else {
                    if ($route->params !== false && strpos($url, $route->url) !== false) {
                        $paramStr = str_replace($route->url, "", $url);
                        $params = explode('/', $paramStr);
                        array_shift($params);
                        if (count($route->params) == count($params)) {
                            $route->params = count($route->params) == 1 ? $params[0] : (object) array_combine($route->params, $params);
                            return $route;
                        }
                    }
                }
            }
            
        }

        return false;
    }

    public static function clearBuffer()
    {
        if (!empty(self::$buffer)) {
            self::$routes = array_merge(self::$routes, self::$buffer);
        }
        self::$buffer = [];
    }

}
