<?php

use core\EnvManager;
use app\User;

class Bootstrap
{
    public function __construct()
    {
        $env = new EnvManager();

        $url;

        if(!isset($_SERVER['PATH_INFO'])) {
            $url = "/";
        }else {
            $url = $_SERVER['PATH_INFO'];
        }

        $requestType = $_SERVER['REQUEST_METHOD'];

        //dd($_SERVER);
        
        $url = str_replace("/anvenxd/public", "", $url);
        Route::clearBuffer();
        //pwb($url);
        //dd(Route::getRoutes());

        if ($url == '/') {
            echo "Welcome to Anven";
            return;
        }
        
        // Collect Route Info
        $route = Route::match($url, $requestType);
        //dd($route);
        
        if (!$route) {
            echo '404 error route not found';
            return;
        } else {
            $controllerFile = __DIR__ . '/../app/controllers/' . $route->controller . '.php';
            if (!file_exists($controllerFile)) {
                //require_once 'controllers/Errors.php';
                $msg = 'No Such Controller Exists "' . $route->controller .'"';
                echo $msg;
                //$controller = new Errors($msg);
                return false;
            }
        }

        //Perform Middleware Actions
        $middlewares = $route->middlewares;

        if($middlewares != null) {
            foreach ($middlewares as $key => $middleware) {
                $middlewareFile = __DIR__ . '/../app/middlewares/' . $middleware . '.php';
                if (!file_exists($middlewareFile)) {
                    //require_once 'controllers/Errors.php';
                    $msg = 'No Such Middleware Exists "' . $middleware .'"';
                    echo $msg;
                    //$controller = new Errors($msg);
                    return false;
                }else {
                    $class = "app\\middlewares\\{$middleware}";
                    $middleware = new $class();
                    $result = $middleware->{"handle"}($route->request, true);
                    
                    if($result !== true) return;
                }
            }
        }

        $class = "app\\controllers\\{$route->controller}";
        $controller = new $class();
        $method = $route->method;
        $params = $route->params;

        if ($method == null) {
            echo "Error:No method given in route!!!";
            return;
        }

        if (method_exists($controller, $method)) {
            $r = new ReflectionMethod($controller, $method);
            $args = count($r->getParameters());

            if($args == 0) echo $controller->{$method}();
            else if($args == 1) echo $params !== false ?  $controller->{$method}($params) :  $controller->{$method}($route->request);
            else if($args == 2) echo $controller->{$method}($route->request, $params);
            else echo "Error: Given method should not have more than 2 arguments Class: '$route->controller', Method: '$method'!!!";
            
        }else {
            echo 'Error:Given method not found for controller!!!' . $route->controller;
            return;
        }
    }
}
