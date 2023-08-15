<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\UserModel;
use app\Model\BookModel;
use app\Model\CartModel;
use app\View\View;

class CartController extends AbsController
{
    protected string $tableName = "books";
    protected string $fieldName = "BookID";
    protected UserModel $userModel;
    protected BookModel $bookModel;
    protected CartModel $cartModel;

    public function __construct(UserModel $userModel, BookModel $bookModel, CartModel $cartModel)
    {
        $this->userModel = new $userModel(databaseName: "eshop");
        $this->bookModel = new $bookModel(databaseName: "eshop");
        $this->cartModel = new $cartModel(databaseName: "eshop");
    }

    private function modifyStock($itemQty, $fieldValue): void
    {
        $bookModel = $this->bookModel->updateBook(tableName: $this->tableName, sanitizedData: ["BookQty" => "BookQty" - $itemQty], fieldName: $this->fieldName, fieldValue: $fieldValue);
    }

    protected function validateStock(mixed $fieldValue): bool
    {
        return  $this->bookModel->validateBook(tableName: $this->tableName, fieldName: $this->fieldName, fieldValue: $fieldValue);
    }

    protected function confirmStockQty(mixed $fieldValue): bool
    {;
        return $this->bookModel->retrieveBookValue(tableName: $this->tableName, fieldName: $this->fieldName, fieldValue: $fieldValue) > 0;
    }

    public function index()
    {
        $cartItems = [];

        $fieldValue = $_GET['BookID'];

        if ($this->validateStock(fieldValue: $fieldValue) && $this->confirmStockQty(fieldValue: $fieldValue)) {
            $newCartItem = $this->bookModel->retrieveSingleBook(tableName: $this->tableName, fieldName: $this->fieldName, fieldValue: $fieldValue);

            $cartItems[] = $newCartItem;
        }

        return View::make('index', [
            'cartItems' => $cartItems,
            'pageTitle' => 'e-shop Cart'
        ]);
    }

    public function store()
    {
        if (filter_has_var(INPUT_POST, 'proceedToCheckOut')) {
            $formData = $_POST;

            $orderStatus = $this->cartModel->createOrder(tableName: "sold", sanitizedData: $formData);

            if ($orderStatus === true) {
                foreach ($formData as $form) {
                    // $this->modifyStock(itemQty: $form[], fieldValue: $form[]);
                }
                $successAlertMsg = "Your Order(s) is/are being processed, A delivery personnel will be in touch shortly";
                $_SESSION['successAlertMsg'] = $successAlertMsg;
                header('Location: /e-shop');
                exit();
            }
            $errorAlertMsg = "Error! Cannot process orders for now, Please try again";
            $_SESSION['errorAlertMsg'] = $errorAlertMsg;
            header('Location: /e-shop');
            exit();
        }
    }
}
