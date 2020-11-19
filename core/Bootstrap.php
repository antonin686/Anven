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

        //print_r ($_SERVER);

        if ($url == '/') {
            echo "Welcome to Anven";
            return;
        }

        $route = Route::match($url);
        if (!$route) {
            echo '404 error route not found';
            return;
        } else {
            $controllerFile = __DIR__ . '/../app/controllers/' . $route->controller . '.php';
            if (!file_exists($controllerFile)) {
                //require_once 'controllers/Errors.php';
                $msg = 'No Such Controller Exists "' . $route->controller.'"';
                echo $msg;
                //$controller = new Errors($msg);
                return false;
            }
        }

        //Route::getRoutes();
        $class = "app\\controllers\\{$route->controller}";
        $controller = new $class();
        $method = $route->method;

        if ($method == null) {
            echo "Error:No given method in route!!!";
            return;
        }

        if (method_exists($controller, $method)) {
            if ($route->type == "get") {
                echo json_encode($controller->{$method}());
            } else if ($route->type == "post") {
                echo json_encode($controller->{$method}($route->request));
            }
        }else {
            echo 'Error:Given method not found for controller ' . $controller;
            return;
        }
    }
}
