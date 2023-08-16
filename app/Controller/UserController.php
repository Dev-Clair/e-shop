<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\UserModel;
use app\Model\BookModel;
use app\Model\CartModel;

class UserController extends AbsController
{
    public function __construct(protected ?UserModel $userModel, protected ?BookModel $bookModel, protected ?CartModel $cartModel)
    {
        parent::__construct($userModel, $bookModel, $cartModel);
    }

    public function index()
    {
        $verifyUserAction = $_GET['register'];

        $welcomePageView = isset($verifyUserAction)
            ?
            $this->view::make(
                'login',
                [
                    'formAction' => '/e-shop/users/register',
                    'pageTitle' => 'e-shop Log in'
                ]
            )
            :
            $this->view::make(
                'register',
                [
                    'formAction' => '/e-shop/users/register',
                    'pageTitle' => 'e-shop Register'
                ]
            );

        return $welcomePageView;
    }

    public function editUser()
    {
        return $this->view::make(
            'edit',
            [
                'formAction' => '/e-shop/users/update',
                'pageTitle' => 'e-shop Update Account'
            ]
        );
    }

    public function showUsers()
    {
        $users = $this->userModel->retrieveAllUsers();

        return $this->view::make(
            'show',
            [
                'users' => $users,
                'pageTitle' => 'e-shop Users'
            ]
        );
    }

    public function updateUser()
    {
    }

    public function deleteUser()
    {
    }

    public function register()
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
