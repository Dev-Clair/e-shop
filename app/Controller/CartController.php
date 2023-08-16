<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\UserModel;
use app\Model\BookModel;
use app\Model\CartModel;

class CartController extends AbsController
{
    public function __construct(protected UserModel $userModel, protected BookModel $bookModel, protected CartModel $cartModel)
    {
        parent::__construct($userModel, $bookModel, $cartModel);
    }

    private function modifyBookQty($itemQty, $fieldValue): void
    {
        $this->bookModel->updateBook(sanitizedData: ["book_qty" => "book_qty - $itemQty"], fieldValue: $fieldValue);
        return;
    }

    protected function confirmBookAvailability(mixed $fieldValue): bool
    {
        return  $this->bookModel->validateBook(fieldValue: $fieldValue);
    }

    protected function confirmBookQty(string $fieldName = "book_qty", mixed $fieldValue): bool
    {
        return $this->bookModel->retrieveBookAttribute(fieldName: $fieldName, fieldValue: $fieldValue) > 0;
    }

    public function index()
    {
        $cartItems = [];

        $fieldValue = $_GET['book_id'];

        if (!$this->confirmBookAvailability(fieldValue: $fieldValue)) {
            $this->errorRedirect(message: "Sorry! This book is currently not available", redirectTo: "");
        }

        if (!$this->confirmBookQty(fieldValue: $fieldValue)) {
            $this->errorRedirect(message: "Sorry! This book is currently out of stock", redirectTo: "");
        }

        $newCartItems = $this->cartModel->retrieveCartItem();

        $cartItems[] = $newCartItems;

        return $this->view::make('index', [
            'cartItems' => $cartItems,
            'pageTitle' => 'e-shop Cart'
        ]);
    }

    public function createOrder()
    {
        if (filter_has_var(INPUT_POST, 'proceedToCheckOut')) {

            $formData = $_POST;

            $orderStatus = $this->cartModel->createOrder(sanitizedData: $formData);

            if ($orderStatus === true) {
                foreach ($formData as $form) {
                    $this->modifyBookQty(itemQty: $form, fieldValue: $form);
                }
                $this->successRedirect(message: "Your Order(s) is/are being processed, A delivery personnel will be in touch shortly", redirectTo: "");
            }
            $this->errorRedirect(message: "Error! Cannot process orders for now, Please try again", redirectTo: "");
        }
    }
}
