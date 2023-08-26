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
        $books = $this->bookModel->retrieveAllBooks(tableName: "books");

        $user_id = $_SESSION['user_id'] ?? null;

        $cart = $this->cartModel->retrieveCartItem(tableName: "cartitems", fieldName: "user_id", fieldValue: $user_id) ?? [];

        return View::make(
            'index',
            [
                'books' => array_slice($books, 0, 50),
                'cart' => $cart,
                'pageTitle' => '&#128366 Books',
                'searchFormAction' => '/e-shop/books/search',
                'cartFormAction' => '/e-shop/books/addToCart'
            ]
        );
    }

    public function create(): View
    {
        $this->verifyAdmin();

        return View::make(
            'e-shop/books/create',
            [
                'formAction' => '/e-shop/store',
                'pageTitle' => '&#128366 Add Book'
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

        $fieldValue = (int)$_GET['book_id'];
        $book = $this->bookModel->retrieveSingleBook(tableName: "books",  fieldName: "book_id", fieldValue: $fieldValue);

        return View::make(
            '/e-shop/books/edit',
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

    protected function validateUpdateAction(int|string $book_id): void
    {
        $fieldValue = $book_id;
        $validateStatus = $this->bookModel->validateBook(tableName: "books",  fieldName: "book_id", fieldValue: $fieldValue);

        if ($validateStatus === true) {
            header('Location: /e-shop/books/edit?book_id=' . $book_id);
            exit();
        }

        $this->errorRedirect(message: "Error! Book $book_id does not exist", redirectTo: "books");
    }

    protected function delete(): void
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

    public function update(): void
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

    public function show(): View
    {
        $this->verifyAdmin();

        return View::make(
            'show',
            []
        );
    }

    public function search(): void
    {
        if (filter_has_var(INPUT_POST, 'searchBook')) {

            $searchInput = filter_input(INPUT_POST, 'searchBook', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $fieldValue = $searchInput;

            $searchResult = $this->bookModel->searchBook(tableName: "books", fieldName: "book_title", fieldValue: $fieldValue);
            if (!empty($searchResult)) {
                $_SESSION['searchResult'] = $searchResult;
                $message = sprintf("%s", "Similar Entries Found for $searchInput");
                $this->successRedirect(message: $message, redirectTo: "");
            }
            $message = sprintf("%s", "No Similar Record Found for &#128366 $searchInput");
            $this->errorRedirect(message: $message, redirectTo: "");
        }
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

    public function addToCart()
    {
        if (filter_has_var(INPUT_POST, 'addToCart')) {

            $this->verifyCustomer() || $this->verifyAdmin();

            $book_id = $_POST['book_id'];

            $book_title = $_POST['book_title'];

            // Confirm Availability
            if (!$this->confirmBookAvailability(tableName: "books", fieldName: "book_id", fieldValue: $book_id)) {
                $this->errorRedirect(message: "Sorry! This book is currently not available", redirectTo: "");
            }

            // Confirm Stock
            if (!$this->confirmBookQty(tableName: "books", fieldName: "book_qty", compareFieldName: "book_id", compareFieldValue: $book_id)) {
                $this->errorRedirect(message: "Sorry! This book is currently out of stock", redirectTo: "");
            }

            // Check if item already exists in cart
            if ($this->preventDuplicates(tableName: "cartitems", fieldName: "book_id", fieldValue: $book_id)) {
                $this->errorRedirect(message: "Item already exists in your cart!", redirectTo: "");
            }

            $user_id = $_SESSION['user_id'];

            $cart_item_id = "crt" . time();

            $default_qty = 1;

            $book = $this->bookModel->retrieveSingleBook(tableName: "books", fieldName: "book_id", fieldValue: $book_id);

            $sanitizedData = [
                "cart_item_id"  => $cart_item_id,
                "user_id" => $user_id,
                "book_id" => $book_id,
                "cart_item_price" => $book["book_price"],
                "cart_item_amt" => $default_qty * $book["book_price"]
            ];

            $addToCartStatus = $this->cartModel->createCartItem(tableName: "cartitems", sanitizedData: $sanitizedData);

            if ($addToCartStatus) {
                $this->cartAddSuccess(message: "Book added to your cart!");
            } else {
                $this->cartAddError(message: "Failed to add book to your cart!");
            }
        }
    }
}
