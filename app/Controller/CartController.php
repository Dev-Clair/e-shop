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
        $this->bookModel->updateBook(
            tableName: "books",
            sanitizedData: ["book_qty" => "book_qty - $itemQty"],
            fieldName: "book_qty",
            fieldValue: $fieldValue
        );
        return;
    }

    public function index()
    {
        $fieldValue = $_SESSION['user_id'] ?? null;

        $cart_items = $this->cartModel->retrieveCartItem(tableName: "cartitems", fieldName: "user_id", fieldValue: $fieldValue) ?? [];

        $cart_items_subtotal = $this->cartModel->retrieveFieldSum(tableName: "cartitems", fieldName: "cart_item_amt", compareFieldName: "user_id", compareFieldValue: $fieldValue) ?? "";

        return View::make(
            'cart/index',
            [
                'cart_items' => $cart_items,
                'cart_items_subtotal' => $cart_items_subtotal,
                'pageTitle' => '&#128366 Cart',
                'searchFormAction' => '/e-shop/books/search',
                'removeFromCartFormAction' => '/e-shop/cart/deleteCartItem',
                'cartQuantityFormAction' => '/e-shop/cart/updateCartItem',
                'proceedToCheckOutFormAction' => '/e-shop/cart/createOrder'
            ]
        );
    }

    public function deleteCartItem()
    {
        if (filter_has_var(INPUT_POST, 'removeFromCart')) {
            if (isset($_POST['removeFromCart']) && is_array($_POST['removeFromCart'])) {
                // Retrieve Form Data via $_POST Super-global
                $cart_item_id = array_key_first($_POST['removeFromCart']);
            }

            $fieldValue = $cart_item_id;

            $this->cartModel->deleteCartItem(tableName: "cartitems", fieldName: "cart_item_id", fieldValue: $fieldValue)
                ?
                $this->successRedirect(message: "Item removed successfully", redirectTo: "cart")
                :
                $this->errorRedirect(message: "Error! Cannot remove item $fieldValue", redirectTo: "cart");

            $this->errorRedirect(message: "Error! Item $cart_item_id does not exist in your cart", redirectTo: "cart");
        }
    }

    public function updateCartItem()
    {
        if (filter_has_var(INPUT_POST, 'alterQty')) {
            // Retrieve Form Data via $_POST Super-global
            $new_qty = filter_input(INPUT_POST, 'new_qty', FILTER_VALIDATE_INT);

            // Retrieve Hidden Form Input: Cart_Item_ID
            $cart_item_id = filter_input(INPUT_POST, 'cart_item_id', FILTER_SANITIZE_SPECIAL_CHARS);

            // Retrieve Hidden Form Input: Cart_Item_Price
            $cart_item_price = filter_input(INPUT_POST, 'cart_item_price', FILTER_VALIDATE_FLOAT);

            if ($new_qty !== false && $new_qty !== null) {
                $sanitizedData = [
                    "cart_item_qty" => $new_qty,
                    "cart_item_amt" => $new_qty * $cart_item_price
                ];
            }

            $this->cartModel->updateCartItem(tableName: "cartitems", sanitizedData: $sanitizedData, fieldName: "cart_item_id", fieldValue: $cart_item_id)
                ?
                $this->successRedirect(message: "Item quantity updated successfully", redirectTo: "cart")
                :
                $this->errorRedirect(message: "Error! Cannot modify quantity", redirectTo: "cart");
        }
    }

    public function createOrder()
    {
        if (filter_has_var(INPUT_POST, 'proceedToCheckOut')) {

            $this->verifyCustomer() || $this->verifyAdmin();

            $order_id_list = [];
            $user_id_list = [];
            $book_id_list = [];
            $order_amt_list = [];

            // Retrieve Cart Data via $_SESSION['user_id']
            $user_id = $_SESSION['user_id'];
            $cart_items = $this->cartModel->retrieveCartItem(tableName: "cartitems", fieldName: "user_id", fieldValue: $user_id);

            // Assign Retrived Cart Data to Orders Array
            for ($item = 0; $item < count($cart_items); $item++) {
                foreach ($cart_items as $cart) {
                    [];
                }
            }

            // Insert Data into Orders Table
            $sanitizedData = [
                // "order_id" => $order_id,
                // "user_id" => $user_id,
                // "book_id" => $book_id,
                // "order_amt" => $order_amt
            ];

            $orderStatus = $this->cartModel->createOrder(tableName: "orders", sanitizedData: $sanitizedData);

            if ($orderStatus === true) {
                $this->cartModel->deleteCartItem(tableName: "cartitems", fieldName: "user_id", fieldValue: $user_id);
                // foreach ($book_id as $book) {
                //     $this->modifyBookQty(itemQty: $book, fieldValue: $book);
                // }
                $this->successRedirect(message: "Your Order(s) is/are being processed, A delivery personnel will be in touch shortly", redirectTo: "");
            }
            $this->errorRedirect(message: "Error! Cannot process orders for now, Please try again", redirectTo: "");
        }
    }
}
