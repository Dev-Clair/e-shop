<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\UserModel;
use app\Model\BookModel;
use app\Model\CartModel;
use app\View\View;

class CartController extends AbsController implements IntPaymentGateWay
{
    public function __construct(UserModel $userModel = null, BookModel $bookModel = null, CartModel $cartModel = null)
    {
        parent::__construct($userModel, $bookModel, $cartModel);
    }

    private function modifyBookQty($itemQty, $fieldValue): void
    {
        $this->bookModel->updateBook(tableName: "books", sanitizedData: ["book_qty" => "book_qty - $itemQty"], fieldName: "book_qty", fieldValue: $fieldValue);
        return;
    }

    public function index()
    {
        $cartItems[] = $this->cartModel->retrieveCartItem(tableName: "cartitems") ?? [];

        return View::make(
            'index',
            [
                'cartItems' => $cartItems,
                'pageTitle' => 'e-shop Cart',
                'formAction' => '/e-shop/cart/createOrder'
            ]
        );
    }

    public function createOrder()
    {
        if (filter_has_var(INPUT_POST, 'proceedToCheckOut')) {

            $formData = $_POST;

            $orderStatus = $this->cartModel->createOrder(tableName: "orders", sanitizedData: $formData);

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
