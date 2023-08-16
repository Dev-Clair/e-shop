<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\UserModel;
use app\Model\BookModel;
use app\Model\CartModel;

abstract class AbsController implements IntController
{
    protected UserModel $userModel;
    protected BookModel $bookModel;
    protected CartModel $cartModel;

    public function __construct(UserModel $userModel = null, BookModel $bookModel = null, CartModel $cartModel = null)
    {
        $this->userModel = $userModel ?: new UserModel(databaseName: "eshop");
        $this->bookModel = $bookModel ?: new $bookModel(databaseName: "eshop");
        $this->cartModel = $cartModel ?: new $cartModel(databaseName: "eshop");
    }

    abstract public function index();

    private function validateLoginStatus(): void
    {
        $user_id = $_SESSION['user_id'];
        if (!isset($user_id) || empty($user_id)) {
            $this->errorRedirect(message: "Invalid Login Status", redirectTo: "login");
        }
        return;
    }

    protected function errorRedirect(string $message, string $redirectTo): void
    {
        $_SESSION['errorAlertMsg'] = $message;
        header('Location: /e-shop/' . $redirectTo);
        exit();
    }

    protected function successRedirect(string $message, string $redirectTo): void
    {
        $_SESSION['successAlertMsg'] = $message;
        header('Location: /e-shop/' . $redirectTo);
        exit();
    }

    protected function cartAddError(string $message): void
    {
        $_SESSION['errorAlertMsg'] = $message;
        return;
    }

    protected function cartAddSuccess(string $message): void
    {
        $_SESSION['successAlertMsg'] = $message;
        return;
    }

    protected function verifyAdmin(): void
    {
        $this->validateLoginStatus();

        $user_id = $_SESSION['user_id'];
        if ($this->userModel->retrieveUserValue(tableName: "users", fieldName: "user_role", fieldValue: $user_id) !== "ADMIN") {
            $this->errorRedirect(message: "Unauthorized Action!", redirectTo: "login");
        }
        return;
    }

    protected function verifyCustomer(): void
    {
        $this->validateLoginStatus();

        $user_id = $_SESSION['user_id'];
        if ($this->userModel->retrieveUserValue(tableName: "users", fieldName: "user_role", fieldValue: $user_id) !== "CUSTOMER") {
            $this->errorRedirect(message: "Unauthorized Action!", redirectTo: "login");
        }
        return;
    }

    protected function sanitizeUserInput(): array
    {
        $sanitizedInput = [];
        foreach ($_POST as $fieldName => $userInput) {
            $sanitizedInput[$fieldName] = filter_var($userInput, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        return $sanitizedInput;
    }
}
