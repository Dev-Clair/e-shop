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
        $books = $this->bookModel->retrieveAllBooks(tableName: "books");

        return View::make(
            'index',
            [
                'books' => array_slice($books, 0, 20),
                'pageTitle' => '&#128366 Home',
                'searchFormAction' => '/e-shop/books/search',
                'cartFormAction' => '/e-shop/books/addToCart'
            ]
        );
    }
}
