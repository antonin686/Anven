<?php
use core\EnvManager;

class Bootstrap
{
    public function __construct()
    {
        $env = new EnvManager();

        $url;

        if (isset($_SERVER['QUERY_STRING'])) {
            $url = '/' . $_SERVER['QUERY_STRING'];
        } else if (isset($_SERVER['REQUEST_URI'])) {
            $url = $_SERVER['REQUEST_URI'];
        }

        $requestType = $_SERVER['REQUEST_METHOD'];

        //print_r ($url);
        Route::clearBuffer();
        //dd(Route::getRoutes());

        if ($url == '/') {
            echo "Welcome to Anven";
            return;
        }

        $url = $requestType. "-" . $url;

        // Collect Route Info
        $route = Route::match($url);
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

        if ($method == null) {
            echo "Error:No given method in route!!!";
            return;
        }

        if (method_exists($controller, $method)) {
            if ($route->type == "get") {
                echo $controller->{$method}();
            } else if ($route->type == "post") {
                echo $controller->{$method}($route->request);
            }
        }else {
            echo 'Error:Given method not found for controller ' . $route->controller;
            return;
        }
    }
}
