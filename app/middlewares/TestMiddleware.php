<?php
namespace app\middlewares;

use core\Middleware;

class TestMiddleware extends Middleware
{
    public function handle($request, $next)
    {
        return $next;
    }
}
