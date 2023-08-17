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

    public function index(): View
    {
        return View::make(
            'users/login',
            [
                'loginFormAction' => '/e-shop/users/login',
                'registerFormAction' => '/e-shop/users/register',
                'pageTitle' => 'e-shop Log in'
            ]
        );
    }

    public function edit(): View
    {
        return View::make(
            'users/edit',
            [
                'formAction' => '/e-shop/users/update',
                'pageTitle' => 'e-shop Update Account'
            ]
        );
    }

    public function show(): View
    {
        $users = $this->userModel->retrieveAllUsers(tableName: "users");

        return View::make(
            'users/show',
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

    public function register(): void
    {
    }

    public function login(): void
    {
        if (filter_has_var(INPUT_POST, 'submitLoginForm')) {
            $errors = [];
            $validInputs = [];

            // Email Field
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            if ($email !== null && $email !== false) {
                $validInputs['email'] = $email;
            } else {
                $errors['email'] = "Please enter a valid email";
            }

            // Password Field
            $password = $_POST['password'];

            $user = $this->userModel->retrieveSingleUser(tableName: "users", fieldName: "email", fieldValue: $validInputs['email']);

            $password_check = password_verify($password, $user['user_password']);
            if (empty($errors) && $password_check) {
                $_SESSION['user_id'] = $user['user_id'];
                $this->successRedirect(message: "Logged in successfully!", redirectTo: "");
            }
            $_SESSION['errors'] = $errors;
            $this->errorRedirect(message: "Error! Invalid Login Details", redirectTo: "users");
        }
    }

    public function logout(): void
    {
        session_start();
        session_destroy();
        unset($_SESSION);
        header('Location: /e-shop/');
        exit();
    }

    protected function retrieveUserInfo()
    {
    }

    protected function verifyUserInfo()
    {
    }
}
