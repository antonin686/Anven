<?php
namespace core;

class Middleware
{
    public function handle($request, $next)
    {
        return $next;
    }
}