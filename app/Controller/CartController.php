<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\UserModel;
use app\Model\BookModel;
use app\Model\CartModel;
use app\View\View;

class CartController extends AbsController implements IntPaymentGateWay
{
    private array $orderLog; // Logs Operation Success or Failure

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
            fieldName: "book_id",
            fieldValue: $fieldValue
        );
        return;
    }

    public function index(): View
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
                'removeFromCartFormAction' => '/e-shop/cart/deleteCartItem',
                'cartQuantityFormAction' => '/e-shop/cart/updateCartItem',
                'proceedToCheckOutFormAction' => '/e-shop/cart/createOrder'
            ]
        );
    }

    public function deleteCartItem(): void
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

    public function updateCartItem(): void
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

    public function createOrder(): void
    {
        if (filter_has_var(INPUT_POST, 'proceedToCheckOut')) {

            $this->verifyCustomer() || $this->verifyAdmin();

            // Logs success or failure of order creation process
            $this->orderLog = [
                'success' => [],
                'error' => []
            ];

            // Retrieve Cart Data via $_SESSION['user_id']
            $user_id = $_SESSION['user_id'];
            $cart_items = $this->cartModel->retrieveCartItem(tableName: "cartitems", fieldName: "user_id", fieldValue: $user_id);

            /**
             * Assign retrieved cart data to orders array
             * Create orders
             * Cache result of the process into a log
             * if successful,
             * Modify the existing stock for the specific record in the books table via the book_id
             * Delete each item from the carts table via the cart_item_id
             * Redirects to home with success message
             * else
             * Redirects to home with error message
             */
            foreach ($cart_items as $key => $item) {

                // Orders table array
                $sanitizedData = [
                    "order_id" => str_ireplace("crt", "ord", $item['cart_item_id']) . $key,
                    "user_id" => $item['user_id'],
                    "book_id" => $item['book_id'],
                    "order_qty" => $item['cart_item_qty'],
                    "order_amt" => $item['cart_item_amt']
                ];

                // Insert orders into orders table
                if ($this->cartModel->createOrder(tableName: "orders", sanitizedData: $sanitizedData) === true) {
                    // Cache result of operation
                    $this->orderLog['success'][] = "{$item['book_id']}, ";

                    // Modify existing book stock based on ordered quantity
                    // $this->modifyBookQty(itemQty: $item['cart_item_qty'], fieldValue: $item['book_id']);

                    // Delete record from cartitems table
                    $this->cartModel->deleteCartItem(tableName: "cartitems", fieldName: "cart_item_id", fieldValue: $item['cart_item_id']);
                } else {
                    // Cache result of operation
                    $this->orderLog['error'][]  = $item['book_id'];
                }

                // Unset $sanitizedData after to prevent carrying over data already inserted into table
                unset($sanitizedData);
            }

            if (!empty($this->orderLog['success'])) {
                $successMessage = "Your order(s) for item(s) " . implode(",", $this->orderLog['success']) . " is being processed, Kindly check your profile to track delivery";
                $this->successRedirect(message: $successMessage, redirectTo: "");
            } else {
                $errorMessage = "Try Again! Cannot process order(s) for item(s) " . implode(",", $this->orderLog['error']) . " is being processed";
                $this->errorRedirect(message: $errorMessage, redirectTo: "");
            }
        }
    }
}
