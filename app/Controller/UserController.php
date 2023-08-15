<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\UserModel;
use app\View\View;

class UserController extends AbsController
{
    protected UserModel $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = new $userModel(databaseName: "eshop");
    }

    public function index()
    {
        $users = $this->userModel->retrieveAllUsers(tableName: "users", fetchMode: "1");

        return View::make('index', [
            'users' => $users,
            'pageTitle' => 'e-shop Profile'
        ]);
    }
}
