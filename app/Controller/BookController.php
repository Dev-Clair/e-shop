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

    public function index(): View
    {
        $retrieved_books = $this->bookModel->retrieveAllBooks(tableName: "books");

        $user_id = $_SESSION['user_id'] ?? null;

        $cart = $this->cartModel->retrieveCartItem(tableName: "cartitems", fieldName: "user_id", fieldValue: $user_id) ?? [];

        return View::make(
            'index',
            [
                'retrieved_books' => array_slice($retrieved_books, 0, 50),
                'cart' => $cart,
                'pageTitle' => '&#128366 Books',
                'searchFormAction' => '/e-shop/books/search',
                'cartFormAction' => '/e-shop/books/addToCart'
            ]
        );
    }

    public function show(): View
    {
        $this->verifyAdmin();

        $retrieved_books = $this->bookModel->retrieveAllBooks(tableName: "books");

        return View::make(
            'books/show',
            [
                'retrieved_books' => $retrieved_books,
                'pageTitle' => '&#128366 Books',
                'adminSearchFormAction' => '/e-shop/books/search',
                'createFormAction' => '/e-shop/books/store',
                'editFormAction' => '/e-shop/books/userAction',
            ]
        );
    }

    public function store(): void
    {
        if (filter_has_var(INPUT_POST, 'submitcreateBook')) {

            $sanitizedInputs = $this->sanitizeUserInput();

            $sanitizedData = $sanitizedInputs;
            if (empty($sanitizedData)) {
                $this->errorRedirect(message: "Error! Cannot Create New Book", redirectTo: "books/create");
            }

            $sanitizedData["book_id"] = "bk" . rand(999, 9999);

            $createStatus = $this->bookModel->createBook(tableName: "books", sanitizedData: $sanitizedData);
            if ($createStatus === true) {
                $this->successRedirect(message: "New Book Added", redirectTo: "books");
            }
            $this->errorRedirect(message: "Error! Cannot Add New Book", redirectTo: "books");
        }
    }

    public function edit(): View
    {
        $this->verifyAdmin();

        $fieldValue = $_GET['book_id'];

        $book = $this->bookModel->retrieveSingleBook(tableName: "books",  fieldName: "book_id", fieldValue: $fieldValue);

        return View::make(
            'books/edit',
            [
                'book' => $book,
                'editFormAction' => '/e-shop/books/update',
                'pageTitle' => '&#128366 Update Book'
            ]
        );
    }

    public function userAction(): void
    {
        if (filter_has_var(INPUT_POST, 'updateBook')) {

            // Update operation
            if (isset($_POST['book_id'])) {

                $book_id = $_POST['book_id'];

                $this->bookModel->validateBook(tableName: "books",  fieldName: "book_id", fieldValue: $book_id)
                    ?
                    header('Location: /e-shop/books/edit?book_id=' . $book_id)
                    :
                    $this->errorRedirect(message: "Error! Book $book_id does not exist", redirectTo: "books");
                exit();
            }
        }

        if (filter_has_var(INPUT_POST, 'deleteBook')) {

            // Delete operation
            $this->delete();
        }
    }

    public function update(): void
    {
        $this->verifyAdmin();

        if (filter_has_var(INPUT_POST, 'submiteditBook')) {

            $sanitizedInputs = $this->sanitizeUserInput();

            $sanitizedData = $sanitizedInputs;
            $fieldValue = $_POST['book_id'];

            $this->bookModel->updateBook(tableName: "books",  fieldName: "book_id", sanitizedData: $sanitizedData, fieldValue: $fieldValue)
                ?
                $this->successRedirect(message: "Book Record Updated", redirectTo: "books/show")
                :
                $this->errorRedirect(message: "Error! Cannot Update Book $fieldValue", redirectTo: "books/show");
        }
    }

    public function search(): void
    {
        if (filter_has_var(INPUT_POST, 'searchBook')) {

            $searchInput = filter_input(INPUT_POST, 'searchBook', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $fieldValue = $searchInput;

            $searchResult = $this->bookModel->searchBook(tableName: "books", fieldName: "book_title", fieldValue: $fieldValue);
            if (!empty($searchResult)) {
                $_SESSION['searchResult'] = $searchResult;
                $message = sprintf("%s", "Similar Records Found for: $searchInput");
                $this->successRedirect(message: $message, redirectTo: "");
            }
            $message = sprintf("%s", "No Similar Record Found for: &#128366 $searchInput");
            $this->errorRedirect(message: $message, redirectTo: "");
        }
    }

    protected function delete(): void
    {
        $this->verifyAdmin();

        if (isset($_POST['deleteBook'])) {
            $book_id = $_POST['book_id'];
        }

        $fieldValue = $book_id;
        $validateStatus = $this->bookModel->validateBook(tableName: "books",  fieldName: "book_id", fieldValue: $fieldValue);

        if ($validateStatus === true) {
            $this->bookModel->deleteBook(tableName: "books",  fieldName: "book_id", fieldValue: $fieldValue)
                ?
                $this->successRedirect(message: "Book Deleted", redirectTo: "books/show")
                :
                $this->errorRedirect(message: "Error! Cannot Delete Book $fieldValue", redirectTo: "books/show");
        }

        $this->errorRedirect(message: "Error! Book $book_id does not exist", redirectTo: "books");
    }

    protected function confirmBookAvailability(string $tableName, string $fieldName, mixed $fieldValue): bool
    {
        return  $this->bookModel->validateBook(tableName: $tableName,  fieldName: $fieldName, fieldValue: $fieldValue);
    }

    protected function confirmBookQty(string $tableName, string $fieldName, string $compareFieldName, mixed $compareFieldValue): bool
    {
        return $this->bookModel->retrieveBookAttribute(tableName: $tableName, fieldName: $fieldName, compareFieldName: $compareFieldName, compareFieldValue: $compareFieldValue) > 0;
    }

    protected function preventDuplicates(string $tableName, string $fieldName, mixed $fieldValue): bool
    {
        return $this->cartModel->preventDuplicates(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }

    public function addToCart(): void
    {
        if (filter_has_var(INPUT_POST, 'addToCart')) {

            // $this->verifyCustomer() || $this->verifyAdmin();

            $book_id = $_POST['book_id'];

            $book_title = $_POST['book_title'];

            // Confirm product availability
            if (!$this->confirmBookAvailability(tableName: "books", fieldName: "book_id", fieldValue: $book_id)) {
                $this->errorRedirect(message: "Sorry! This book is currently not available", redirectTo: "");
            }

            // Confirm product stock
            if (!$this->confirmBookQty(tableName: "books", fieldName: "book_qty", compareFieldName: "book_id", compareFieldValue: $book_id)) {
                $this->errorRedirect(message: "Sorry! This book is currently out of stock", redirectTo: "");
            }

            // Check if item already exists in cart
            if ($this->preventDuplicates(tableName: "cartitems", fieldName: "book_id", fieldValue: $book_id)) {
                $this->errorRedirect(message: "Item already exists in your cart!", redirectTo: "");
            }

            $user_id = $_SESSION['user_id'] ?? null;

            $cart_no = rand(9, 989);
            $cart_item_id = "crt" . $cart_no++;

            $default_qty = 1;

            $book = $this->bookModel->retrieveSingleBook(tableName: "books", fieldName: "book_id", fieldValue: $book_id);

            $sanitizedData = [
                "cart_item_id"  => $cart_item_id,
                "user_id" => $user_id,
                "book_id" => $book_id,
                "book_title" => $book_title,
                "cart_item_price" => $book["book_price"],
                "cart_item_amt" => $default_qty * $book["book_price"]
            ];

            if (is_null($user_id)) {
                $this->errorRedirect(message: "Unauthorized! Kindly Login", redirectTo: "users");
            }

            $this->cartModel->createCartItem(tableName: "cartitems", sanitizedData: $sanitizedData)
                ?
                $this->cartAddSuccess(message: "Book added to your cart!")
                :
                $this->cartAddError(message: "Failed to add book to your cart!");
        }
    }
}
