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
        if (filter_has_var(INPUT_POST, 'submitRegisterForm')) {
            $errors = [];
            $validInputs = [];

            // Name Field
            $regpattern = '/^[A-Za-z]+(?:\s+[A-Za-z]+)*$/';
            $name = filter_input(INPUT_POST, 'name', FILTER_VALIDATE_REGEXP, array(
                'options' => array('regexp' => $regpattern)
            ));

            if ($name !== false && $name !== null) {
                $validInputs['name'] = ucwords($name);
            } else {
                $errors['name'] = "Name cannot contain numbers or non-alpahbetic characters";
            }

            // Email Field
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

            if ($email !== null && $email !== false) {
                $validInputs['email'] = $email;
            } else {
                $errors['email'] = "Please enter a valid email";
            }

            // Password Field
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password !== $confirm_password) {
                $errors['password'] = "Passwords do not match";
                $errors['confirm_password'] = "Passwords do not match";
            }
            $validInputs['password'] = password_hash($password, PASSWORD_BCRYPT);

            // Address Field
            $address = filter_input(INPUT_POST, 'address', FILTER_DEFAULT);

            if (!is_string($address)) {
                $errors['address'] = "Address is not valid";
            }
            $validInputs['address'] = $address;

            if (!empty($errors)) {
                $this->errorRedirect(message: "Error! Invalid Details", redirectTo: "users");
            }
            // Submit Form
            $user_id = "cus" . time();
            $newRecord = [
                "user_id" => $user_id,
                "user_name" => $validInputs['name'],
                "user_email" => $validInputs['email'],
                "user_password" => $validInputs['password'],
                "user_address" => $validInputs['address']
            ];

            $this->userModel->createUser(tableName: "users", sanitizedData: $newRecord)
                ?
                $this->successRedirect(message: "Account Creation was Successful, You can now login", redirectTo: "users")
                :
                $this->errorRedirect(message: "Error! Account Creation Failed, Please Try Again", redirectTo: "users");
        }
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

            // User Verification
            $user = $this->userModel->retrieveSingleUser(tableName: "users", fieldName: "user_email", fieldValue: $validInputs['email']);

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
