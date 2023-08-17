<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\UserModel;
use app\Model\BookModel;
use app\Model\CartModel;
use app\View\View;

class BookController extends AbsController
{
    public function __construct()
    {
        $userModel = new UserModel(databaseName: "eshop");
        $bookModel = new BookModel(databaseName: "eshop");
        $cartModel = new CartModel(databaseName: "eshop");

        parent::__construct($userModel, $bookModel, $cartModel);
    }

    public function index()
    {
        $books = $this->bookModel->retrieveAllBooks(tableName: "books");

        return View::make(
            'index',
            [
                'books' => array_slice($books, 0, 50),
                'pageTitle' => 'e-shop Books',
                'searchFormAction' => '/e-shop/books/search',
                'cartFormAction' => '/e-shop/books/addToCart'
            ]
        );
    }

    public function create()
    {
        $this->verifyAdmin();

        return View::make(
            'e-shop/books/create',
            [
                'formAction' => '/e-shop/store',
                'pageTitle' => 'Add Book'
            ]
        );
    }

    public function store()
    {
        if (filter_has_var(INPUT_POST, 'submitcreateBook')) {

            $sanitizedInputs = $this->sanitizeUserInput();

            $sanitizedData = $sanitizedInputs;
            if (empty($sanitizedData)) {
                $this->errorRedirect(message: "Error! Cannot Create New Book", redirectTo: "books/create");
            }
            $createStatus = $this->bookModel->createBook(tableName: "books", sanitizedData: $sanitizedData);
            if ($createStatus === true) {
                $this->successRedirect(message: "New Book Added", redirectTo: "books");
            }
            $this->errorRedirect(message: "Error! Cannot Add New Book", redirectTo: "books");
        }
    }

    public function edit()
    {
        $this->verifyAdmin();

        $fieldValue = (int)$_GET['book_id'];
        $book = $this->bookModel->retrieveSingleBook(tableName: "books",  fieldName: "book_id", fieldValue: $fieldValue);

        return View::make(
            '/e-shop/books/edit',
            [
                'book' => $book,
                'formAction' => '/e-shop/books/update',
                'pageTitle' => 'Update Book'
            ]
        );
    }

    public function userAction()
    {
        if (filter_has_var(INPUT_POST, 'updateBook')) {

            if (isset($_POST['updateBook']) && is_array($_POST['updateBook'])) {
                $book_id = array_key_first($_POST['updateBook']);

                // Retrieve and pass $_POST['updateBook'] value to validateUpdate method
                $this->validateUpdateAction(book_id: $book_id);
            }
        }

        if (filter_has_var(INPUT_POST, 'deleteBook')) {
            $this->delete();
        }
    }

    protected function validateUpdateAction(int|string $book_id)
    {
        $fieldValue = $book_id;
        $validateStatus = $this->bookModel->validateBook(tableName: "books",  fieldName: "book_id", fieldValue: $fieldValue);

        if ($validateStatus === true) {
            header('Location: /e-shop/books/edit?book_id=' . $book_id);
            exit();
        }

        $this->errorRedirect(message: "Error! Book $book_id does not exist", redirectTo: "books");
    }

    protected function delete()
    {
        $this->verifyAdmin();

        if (isset($_POST['deleteBook']) && is_array($_POST['deleteBook'])) {
            $book_id = array_key_first($_POST['deleteBook']);
        }

        $fieldValue = $book_id;
        $validateStatus = $this->bookModel->validateBook(tableName: "books",  fieldName: "book_id", fieldValue: $fieldValue);

        if ($validateStatus === true) {
            $this->bookModel->deleteBook(tableName: "books",  fieldName: "book_id", fieldValue: $fieldValue)
                ?
                $this->successRedirect(message: "Book Deleted", redirectTo: "books")
                :
                $this->errorRedirect(message: "Error! Cannot Delete Book $fieldValue", redirectTo: "books");
        }

        $this->errorRedirect(message: "Error! Book $book_id does not exist", redirectTo: "books");
    }

    public function update()
    {
        $this->verifyAdmin();

        if (filter_has_var(INPUT_POST, 'submiteditBook')) {

            $sanitizedInputs = $this->sanitizeUserInput();

            $sanitizedData = $sanitizedInputs;
            $fieldValue = $_POST['book_id'];

            $this->bookModel->updateBook(tableName: "books",  fieldName: "book_id", sanitizedData: $sanitizedData, fieldValue: $fieldValue)
                ?
                $this->successRedirect(message: "Book Record Updated", redirectTo: "books")
                :
                $this->errorRedirect(message: "Error! Cannot Update Book $fieldValue", redirectTo: "books");
        }
    }

    public function show()
    {
        $this->verifyAdmin();

        $books = $this->bookModel->retrieveAllBooks(tableName: "books");

        return View::make(
            'index',
            [
                'books' => array_slice($books, 0, 50),
                'pageTitle' => 'e-shop Home',
                'searchFormAction' => '/e-shop/books/search',
                'tableFormAction' => '/e-shop/books/userAction'
            ]
        );
    }

    public function search()
    {
        if (filter_has_var(INPUT_POST, 'searchBook')) {

            $searchInput = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $fieldValue = $searchInput;
            $validateStatus = $this->bookModel->validateBook(tableName: "books", fieldName: "book_title", fieldValue: $fieldValue);

            if ($validateStatus) {
                $book_title = $this->bookModel->retrieveBookAttribute(tableName: "books", fieldName: "book_title", fieldValue: $fieldValue);
                $message = sprintf("%s", "&#128366; Book: $book_title");
                $this->successRedirect(message: $message, redirectTo: "books");
            };
            $message = sprintf("%s", "No Book Record found for &#128366 $searchInput");
            $this->errorRedirect(message: $message, redirectTo: "books");
        }
    }

    protected function confirmBookAvailability(mixed $fieldValue): bool
    {
        return  $this->bookModel->validateBook(tableName: "books",  fieldName: "book_id", fieldValue: $fieldValue);
    }

    protected function confirmBookQty(string $fieldName = "book_qty", mixed $fieldValue): bool
    {
        return $this->bookModel->retrieveBookAttribute(tableName: "books", fieldName: $fieldName, fieldValue: $fieldValue) > 0;
    }

    public function addToCart()
    {
        if (filter_has_var(INPUT_POST, 'addToCart')) {
            $this->verifyCustomer() || $this->verifyAdmin();

            $book_id = $_GET['book_id'];

            if (!$this->confirmBookAvailability(fieldValue: $book_id)) {
                $this->errorRedirect(message: "Sorry! This book is currently not available", redirectTo: "");
            }

            if (!$this->confirmBookQty(fieldValue: $book_id)) {
                $this->errorRedirect(message: "Sorry! This book is currently out of stock", redirectTo: "");
            }

            $user_id = $_SESSION['user_id'];

            $cart_item_id = "crt" . time();

            $book = $this->bookModel->retrieveSingleBook(tableName: "books", fieldName: "book_id", fieldValue: $book_id);

            $sanitizedData = ["cart_item_id"  => $cart_item_id, "user_id" => $user_id, "book_id" => $book_id, "item_qty" => 1, "item_amt" => $book["book_price"]];

            $addToCartStatus = $this->cartModel->createCartItem(tableName: "cartitems", sanitizedData: $sanitizedData);

            if ($addToCartStatus) {
                $this->cartAddSuccess(message: "Book added to your cart!");
            } else {
                $this->cartAddError(message: "Failed to add book to your cart!");
            }
        }
    }
}
