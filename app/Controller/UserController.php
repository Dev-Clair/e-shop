<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\UserModel;
use app\Model\BookModel;
use app\Model\CartModel;
use app\View\View;

class UserController extends AbsController
{
    public function __construct()
    {
        $userModel = new UserModel(databaseName: "eshop");
        $bookModel = new BookModel(databaseName: "eshop");
        $cartModel = new CartModel(databaseName: "eshop");

        parent::__construct($userModel, $bookModel, $cartModel);
    }

    public function index()
    {
        $verifyUserAction = $_GET['register'];

        $welcomePageView = isset($verifyUserAction)
            ?
            View::make(
                'register',
                [
                    'formAction' => '/e-shop/users/customerRegister',
                    'pageTitle' => 'e-shop Register'
                ]
            )
            :
            View::make(
                'login',
                [
                    'formAction' => '/e-shop/users/login',
                    'pageTitle' => 'e-shop Log in'
                ]
            );

        return $welcomePageView;
    }

    public function edit()
    {
        return View::make(
            'edit',
            [
                'formAction' => '/e-shop/users/update',
                'pageTitle' => 'e-shop Update Account'
            ]
        );
    }

    public function show()
    {
        $users = $this->userModel->retrieveAllUsers(tableName: "users");

        return View::make(
            'show',
            [
                'users' => $users,
                'pageTitle' => 'e-shop Users'
            ]
        );
    }

    public function update()
    {
    }

    public function delete()
    {
    }

    public function customerRegister()
    {
    }

    public function adminRegister()
    {
    }

    public function login()
    {
    }

    public function logout()
    {
        session_start();
        session_destroy();
        unset($_SESSION);
        header('Location: /e-shop/login');
        exit();
    }

    protected function retrieveUserInfo()
    {
    }

    protected function verifyUserInfo()
    {
    }
}
