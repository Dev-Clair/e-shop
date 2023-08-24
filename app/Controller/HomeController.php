<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\UserModel;
use app\Model\BookModel;
use app\Model\CartModel;
use app\View\View;

class HomeController extends AbsController
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
        // Create Login Functionality and retry admin verification
        // $this->verifyAdmin();

        $books = $this->bookModel->retrieveAllBooks(tableName: "books");

        $user_id = $_SESSION['user_id'] ?? null;

        $cart = $this->cartModel->retrieveCartItem(tableName: "cartitems", fieldName: "user_id", fieldValue: $user_id) ?? [];

        return View::make('index', [
            'books' => array_slice($books, 0, 20),
            'cart' => $cart,
            'pageTitle' => 'e-shop Home',
            'searchFormAction' => '/e-shop/books/search',
            'cartFormAction' => '/e-shop/books/addToCart'
        ]);
    }
}
