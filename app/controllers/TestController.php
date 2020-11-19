<?php
namespace app\controllers;

use app\controllers\Controller;
use app\User;

class TestController extends Controller
{
    public function index()
    {
        $user = User::find(2);
        return $user;
    }
}
