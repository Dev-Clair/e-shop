<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\BookModel;
use app\Model\TransactionModel;
use app\View\View;

class CartController extends AbsController
{
    protected string $tableName = "stock";
    protected string $fieldName = "BookID";

    private function modifyStock($itemQty, $fieldValue): void
    {
        $bookModel = new BookModel("eshop");

        $bookModel = $bookModel->updateBook(tableName: $this->tableName, sanitizedData: ["BookQty" => "BookQty" - $itemQty], fieldName: $this->fieldName, fieldValue: $fieldValue);
    }

    protected function validateStock(BookModel $bookModel, $fieldValue): bool
    {
        return  $bookModel->validateBook(tableName: $this->tableName, fieldName: $this->fieldName, fieldValue: $fieldValue);
    }

    protected function confirmStockQty(BookModel $bookModel, $fieldValue): bool
    {;
        return $bookModel->retrieveBookValue(tableName: $this->tableName, fieldName: $this->fieldName, fieldValue: $fieldValue) > 0;
    }

    public function index()
    {
        $bookModel = new BookModel("eshop");

        $cartItems = [];

        $fieldValue = $_GET['BookID'];

        if ($this->validateStock(bookModel: $bookModel, fieldValue: $fieldValue) && $this->confirmStockQty(bookModel: $bookModel, fieldValue: $fieldValue)) {
            $newCartItem = $bookModel->retrieveSingleBook(tableName: $this->tableName, fieldName: $this->fieldName, fieldValue: $fieldValue);

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

            $transactionModel = new TransactionModel(databaseName: "eshop");
            $transactionStatus = $transactionModel->createTransaction(tableName: "sold", sanitizedData: $formData);

            if ($transactionStatus === true) {
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
