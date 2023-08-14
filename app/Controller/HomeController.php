<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\BookModel;
use app\View\View;

class HomeController extends AbsController
{
    public function index()
    {
        $bookModel = new BookModel(databaseName: "eshop");
        $books = $bookModel->retrieveAllBooks(tableName: "stock", fetchMode: "1");

        return View::make('index', [
            'book' => array_slice($books, 0, 20),
            'pageTitle' => 'e-shop Home',
            'searchFormAction' => '/e-shop/search',
            'tableFormAction' => '/e-shop/userAction'
        ]);
    }
}
