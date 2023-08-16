<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\UserModel;
use app\Model\BookModel;
use app\Model\CartModel;

class HomeController extends AbsController
{
    public function __construct(protected ?UserModel $userModel, protected ?BookModel $bookModel, protected ?CartModel $cartModel)
    {
        parent::__construct($userModel, $bookModel, $cartModel);
    }

    public function index()
    {
        $books = $this->bookModel->retrieveAllBooks();

        return $this->view::make('index', [
            'book' => array_slice($books, 0, 20),
            'pageTitle' => 'e-shop Home',
            'searchFormAction' => '/e-shop/books/search',
            'cartFormAction' => '/e-shop/books/addToCart'
        ]);
    }
}
