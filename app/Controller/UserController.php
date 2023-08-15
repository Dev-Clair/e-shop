<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\UserModel;
use app\Model\BookModel;
use app\Model\CartModel;
use app\View\View;

class UserController extends AbsController
{
    public function __construct(protected ?UserModel $userModel, protected ?BookModel $bookModel, protected ?CartModel $cartModel)
    {
        parent::__construct($userModel, $bookModel, $cartModel);
    }

    public function index()
    {
        $users = $this->userModel->retrieveAllUsers();

        return View::make('index', [
            'users' => $users,
            'pageTitle' => 'e-shop Profile'
        ]);
    }

    public function userRegistration()
    {
    }

    public function userLogin()
    {
    }

    public function userLogout()
    {
    }

    public function retrieveUserInfo()
    {
    }

    public function verifyUserInfo()
    {
    }

    public function updateUserInfo()
    {
    }

    public function userAccountStatus()
    {
    }
}
