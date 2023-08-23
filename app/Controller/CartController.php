<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\UserModel;
use app\Model\BookModel;
use app\Model\CartModel;
use app\View\View;

class CartController extends AbsController implements IntPaymentGateWay
{
    public function __construct()
    {
        $userModel = new UserModel(databaseName: "eshop");
        $bookModel = new BookModel(databaseName: "eshop");
        $cartModel = new CartModel(databaseName: "eshop");

        parent::__construct($userModel, $bookModel, $cartModel);
    }

    private function modifyBookQty($itemQty, $fieldValue): void
    {
        $this->bookModel->updateBook(tableName: "books", sanitizedData: ["book_qty" => "book_qty - $itemQty"], fieldName: "book_qty", fieldValue: $fieldValue);
        return;
    }

    public function index()
    {
        $cart_items[] = $this->cartModel->retrieveCartItem(tableName: "cartitems") ?? [];

        return View::make(
            'cart/index',
            [
                'cart_items' => $cart_items,
                'pageTitle' => 'e-shop Cart',
                'searchFormAction' => '/e-shop/books/search',
                'formAction' => '/e-shop/cart/createOrder'
            ]
        );
    }

    public function createOrder()
    {
        if (filter_has_var(INPUT_POST, 'proceedToCheckOut')) {
            $cart_item_id = [];
            $order = [];
            $user_id = $_SESSION['user_id'];
            $book_id = [];
            $order_amt = [];

            $sanitizedData = [
                "order_id"  => $cart_item_id,
                "user_id" => $user_id,
                "book_id" => $book_id,
                "order_amt" => $order_amt
            ];

            $orderStatus = $this->cartModel->createOrder(tableName: "orders", sanitizedData: $sanitizedData);

            if ($orderStatus === true) {
                $this->cartModel->deleteCartItem(tableName: "cartitems", fieldName: "user_id", fieldValue: $user_id);
                foreach ($book_id as $book) {
                    $this->modifyBookQty(itemQty: $book, fieldValue: $book);
                }
                $this->successRedirect(message: "Your Order(s) is/are being processed, A delivery personnel will be in touch shortly", redirectTo: "");
            }
            $this->errorRedirect(message: "Error! Cannot process orders for now, Please try again", redirectTo: "");
        }
    }
}
