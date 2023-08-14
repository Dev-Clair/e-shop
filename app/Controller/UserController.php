<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\UserModel;
use app\View\View;

class UserController extends AbsController
{
    public function index()
    {
        $userModel = new UserModel(databaseName: "eshop");
        $users = $userModel->retrieveAllUsers(tableName: "users", fetchMode: "1");

        return View::make('index', [
            'users' => $users,
            'pageTitle' => 'e-shop Profile'
        ]);
    }
}
