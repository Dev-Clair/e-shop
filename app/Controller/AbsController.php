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
        $this->userModel = $userModel ?: new $userModel(databaseName: "eshop");
        $this->bookModel = $bookModel ?: new $bookModel(databaseName: "eshop");
        $this->cartModel = $cartModel ?: new $cartModel(databaseName: "eshop");
    }

    abstract public function index();

    private function validateLoginStatus(): void
    {
        if (isset($_SESSION['user_id'])) {
            session_regenerate_id(true);
            return;
        }
        $this->errorRedirect(message: "Invalid Login Status", redirectTo: "users");
    }

    protected function sanitizeUserInput(): array
    {
        $sanitizedInput = [];
        foreach ($_POST as $fieldName => $userInput) {
            $sanitizedInput[$fieldName] = filter_var($userInput, FILTER_SANITIZE_SPECIAL_CHARS);
        }
        unset($sanitizedInput[array_key_last($sanitizedInput)]);
        return $sanitizedInput;
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
        header('Location: /e-shop/');
        return;
    }

    protected function cartAddSuccess(string $message): void
    {
        $_SESSION['successAlertMsg'] = $message;
        header('Location: /e-shop/');
        return;
    }

    protected function verifyAdmin(): void
    {
        $this->validateLoginStatus();

        if (
            $this->userModel->retrieveUserAttribute(tableName: "users", fieldName: "user_role", compareFieldName: 'user_id', compareFieldValue: $_SESSION['user_id']) !== "ADMIN"
        ) {
            $this->errorRedirect(message: "Unauthorized!", redirectTo: "");
        }
        return;
    }

    protected function verifyCustomer(): void
    {
        $this->validateLoginStatus();

        if (
            $this->userModel->retrieveUserAttribute(tableName: "users", fieldName: "user_role", compareFieldName: 'user_id', compareFieldValue: $_SESSION['user_id']) !== "CUSTOMER"
        ) {
            $this->errorRedirect(message: "Unauthorized!", redirectTo: "");
        }
        return;
    }
}
