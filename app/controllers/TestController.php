<?php
namespace app\controllers;

use app\controllers\Controller;
use app\User;
use database\DB;

class TestController extends Controller
{
    public function index()
    {
        // return User::find(1);
        // DB::invoke("Update users set password='12' where id = 1");
        return DB::query('Select * from users');
    }
}
