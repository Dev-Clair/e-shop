<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\UserModel;
use app\Model\BookModel;
use app\Model\CartModel;
use app\View\View;

class UserController extends AbsController
{
    public function __construct(UserModel $userModel = null, BookModel $bookModel = null, CartModel $cartModel = null)
    {
        parent::__construct($userModel, $bookModel, $cartModel);
    }

    public function index()
    {
        $verifyUserAction = $_GET['register'];

        $welcomePageView = isset($verifyUserAction)
            ?
            View::make(
                'login',
                [
                    'formAction' => '/e-shop/users/register',
                    'pageTitle' => 'e-shop Log in'
                ]
            )
            :
            View::make(
                'register',
                [
                    'formAction' => '/e-shop/users/register',
                    'pageTitle' => 'e-shop Register'
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
    }

    protected function retrieveUserInfo()
    {
    }

    protected function verifyUserInfo()
    {
    }

    protected function setUserAccountStatus()
    {
    }
}
