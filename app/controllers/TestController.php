<?php
namespace app\controllers;

use app\controllers\Controller;
use app\User;
use database\DB;

class TestController extends Controller
{
    public function index($request,$params, $dasd)
    {
        // return User::find(1);
        // DB::invoke("Update users set password='12' where id = 1");
        return json(DB::query('Select * from users'));
    }

    public function create($request)
    {
        $user = User::create([
            'username' => $request->username,
            'password' => $request->password,
        ]);
        return $user;
    }

    public function update($request)
    {
       // return $request;

        dd($request);
    }

    public function show($params)
    {
        dd($params);
    }
}
