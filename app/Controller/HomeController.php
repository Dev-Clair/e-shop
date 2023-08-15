<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\BookModel;
use app\View\View;

class HomeController extends AbsController
{
    protected BookModel $bookModel;

    public function __construct(BookModel $bookModel)
    {
        $this->bookModel = new $bookModel(databaseName: "eshop");
    }

    public function index()
    {
        $books = $this->bookModel->retrieveAllBooks(tableName: "books", fetchMode: "1");

        return View::make('index', [
            'book' => array_slice($books, 0, 20),
            'pageTitle' => 'e-shop Home',
            'searchFormAction' => '/e-shop/search',
            'tableFormAction' => '/e-shop/userAction'
        ]);
    }
}
