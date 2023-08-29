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
        // MIDDLEWARE :: Prevents already logged-in user from accessing this page
        if (isset($_SESSION['user_id'])) {
            $this->errorRedirect(message: "Unauthorized!", redirectTo: "");
        }

        return View::make(
            'users/login',
            [
                'loginFormAction' => '/e-shop/users/login',
                'registerFormAction' => '/e-shop/users/register',
                'pageTitle' => '&#128366 Log in'
            ]
        );
    }

    public function customerProfile(): View
    {
        return View::make(
            'users/profile',
            [
                'profileFormAction' => '/e-shop/users/profile',
                'formID' => 'CUSTOMER',
                'pageTitle' => '&#128366 Account Profile'
            ]
        );
    }

    public function adminProfile(): View
    {
        return View::make(
            'users/profile',
            [
                'profileFormAction' => '/e-shop/users/profile',
                'formID' => 'ADMIN',
                'pageTitle' => '&#128366 Account Profile'
            ]
        );
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
            $email = filter_input(INPUT_POST, 'registerEmail', FILTER_VALIDATE_EMAIL);

            if ($email !== null && $email !== false) {
                $validInputs['email'] = $email;
            } else {
                $errors['registerEmail'] = "Please enter a valid email";
            }

            // Password Field
            $password = $_POST['registerPassword'];
            $confirm_password = $_POST['confirm_registerPassword'];

            if ($password !== $confirm_password) {
                $errors['registerPassword'] = "Passwords do not match";
                $errors['confirm_registerPassword'] = "Passwords do not match";
            }
            $validInputs['password'] = password_hash($password, PASSWORD_BCRYPT);

            // Address Field
            $address = filter_input(INPUT_POST, 'address', FILTER_DEFAULT);

            if (!is_string($address)) {
                $errors['address'] = "Address is not valid";
            }
            $validInputs['address'] = $address;

            // User Role - Hidden Field
            $user_role = $_POST['passkey'] ?: null;

            // Check for userinput Errors
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $this->errorRedirect(message: "Error! Invalid Details", redirectTo: "users");
            }

            // Submit Form
            $user_id = rand(999, 9999);

            $customerRecord = [
                "user_id" => 'cus' . $user_id++,
                "user_name" => $validInputs['name'],
                "user_email" => $validInputs['email'],
                "user_password" => $validInputs['password'],
                "user_address" => $validInputs['address']
            ];

            $adminRecord = [
                "user_id" => 'adm' . $user_id++,
                "user_name" => $validInputs['name'],
                "user_email" => $validInputs['email'],
                "user_password" => $validInputs['password'],
                "user_address" => $validInputs['address'],
                "user_role" => $user_role
            ];

            $this->userModel->createUser(tableName: "users", sanitizedData: isset($user_role) ? $adminRecord : $customerRecord)
                ?
                $this->successRedirect(message: "Account Creation Successful, kindly login", redirectTo: "users")
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
            $email = filter_input(INPUT_POST, 'loginEmail', FILTER_VALIDATE_EMAIL);
            if ($email !== null && $email !== false) {
                $validInputs['email'] = $email;
            } else {
                $errors['loginEmail'] = "Please enter a valid email";
            }

            // Password Field
            $password = $_POST['loginPassword'];

            // Check for userinput Errors
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $this->errorRedirect(message: "Error! Fields Cannot be Empty", redirectTo: "users");
            }

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

        // Retrieve user_id via Session Super-Global
        $user_id = $_SESSION['user_id'];

        // Check and clear cart of items added via user's user_id
        $this->cartModel->deleteCartItem(tableName: "cartitems", fieldName: "user_id", fieldValue: $user_id);

        // Destroy and unset session
        session_destroy();
        unset($_SESSION);
        header('Location: /e-shop/');
        exit();
    }

    public function show(): View
    {
        $users = $this->userModel->retrieveAllUsers(tableName: "users");

        return View::make(
            'users/show',
            [
                'users' => $users,
                'pageTitle' => '&#128366 Users'
            ]
        );
    }

    public function update(): void
    {
    }

    public function delete(): void
    {
    }

    private function validateEmail(): string|null
    {
        return filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL | FILTER_VALIDATE_EMAIL);
    }

    protected function authenticateUser(): bool
    {
        $password = $_POST['user_password'];

        $user_password = $this->userModel->retrieveUserAttribute(tableName: "users", fieldName: "user_password", compareFieldName: 'user_id', compareFieldValue: $_SESSION['user_id']);

        return password_verify($password, $user_password);
    }

    protected function retrieveUserAccountStatus($user_email): string|null
    {
        $this->verifyAdmin();

        if (is_null($user_email)) {
            $this->errorRedirect(message: "Invalid! Pleae enter a valid email address", redirectTo: "");
        }

        return $this->userModel->retrieveUserAttribute(tableName: "users", fieldName: "user_account_status", compareFieldName: 'user_email', compareFieldValue: $user_email);
    }

    protected function setUserAccountStatus(): void
    {
        $this->verifyAdmin();

        $user_email = $this->validateEmail();

        $user_account_status = $this->retrieveUserAccountStatus($user_email);

        if ($user_account_status === "Active") {
            $this->userModel->updateUser(tableName: "users", sanitizedData: ["user_account_status" => "Inactive"], fieldName: "user_email", fieldValue: $user_email);
        } else {
            $this->userModel->updateUser(tableName: "users", sanitizedData: ["user_account_status" => "Active"], fieldName: "user_email", fieldValue: $user_email);
        }
    }
}
