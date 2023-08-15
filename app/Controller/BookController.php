<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\UserModel;
use app\Model\BookModel;
use app\Model\CartModel;
use app\View\View;

class BookController extends AbsController
{
    public function __construct(protected ?UserModel $userModel, protected ?BookModel $bookModel, protected ?CartModel $cartModel)
    {
        parent::__construct($userModel, $bookModel, $cartModel);
    }

    public function index()
    {
        $books = $this->bookModel->retrieveAllBooks(tableName: "books", fetchMode: "1");

        return View::make('index', [
            'books' => array_slice($books, 0, 50),
            'pageTitle' => 'e-shop Home',
            'searchFormAction' => '/e-shop/books/search',
            'tableFormAction' => '/e-shop/books/userAction'
        ]);
    }

    public function addToCart()
    {
        $book_id = $_GET['book_id'];

        $user_id = $_SESSION['user_id'];

        $cart_item_id = "crt" . time();

        $book = $this->bookModel->retrieveSingleBook(tableName: "books", fieldName: "book_id", fieldValue: $book_id);

        $sanitizedData = ["cart_item_id"  => $cart_item_id, "user_id" => $user_id, "book_id" => $book_id, "item_qty" => 1, "item_amt" => $book["book_price"]];

        $addToCartStatus = $this->cartModel->createCartItem(sanitizedData: $sanitizedData);

        if ($addToCartStatus) {
            $successAlertMsg = "Book added to your cart!";
            $_SESSION['successAlertMsg'] = $successAlertMsg;
        } else {
            $errorAlertMsg = "Failed to add book to your cart.";
            $_SESSION['errorAlertMsg'] = $errorAlertMsg;
        }
        header('Location: /e-shop/books');
        exit();
    }

    public function newBook()
    {
        $formAction = '/e-shop/store';
        $pageTitle = "Add Book";
        return View::make('e-shop/books/create', ['formAction' => $formAction, 'pageTitle' => $pageTitle]);
    }

    public function storeBook()
    {
        if (filter_has_var(INPUT_POST, 'submitcreateBook')) {

            $sanitizedInputs = [];


            $sanitizedData = $sanitizedInputs;
            $createStatus = $this->bookModel->createBook(sanitizedData: $sanitizedData);
            if ($createStatus === true) {
                $successAlertMsg = "New Book Added";
                $_SESSION['successAlertMsg'] = $successAlertMsg;
                header('Location: /e-shop/books');
                exit();
            }
            $errorAlertMsg = "Error! Cannot Add Book";
            $_SESSION['errorAlertMsg'] = $errorAlertMsg;
            header('Location: /e-shop/books');
            exit();
        }
    }

    public function editBook()
    {
        $fieldValue = (int)$_GET['book_id'];
        $book = $this->bookModel->retrieveSingleBook(fieldValue: $fieldValue);
        $formAction = '/e-shop/books/update';
        $pageTitle = "Update Book";
        return View::make('/e-shop/books/edit', ['book' => $book, 'formAction' => $formAction, 'pageTitle' => $pageTitle]);
    }

    public function userAction()
    {
        if (filter_has_var(INPUT_POST, 'updateBook')) {

            if (isset($_POST['updateBook']) && is_array($_POST['updateBook'])) {
                $bookID = array_key_first($_POST['updateBook']);

                // Retrieve and pass $_POST['updateBook'] value to validateUpdate method
                $this->validateUpdateBookAction(bookID: $bookID);
            }
        }

        if (filter_has_var(INPUT_POST, 'deleteBook')) {
            $this->deleteBook();
        }
    }

    protected function validateUpdateBookAction(int|string $bookID)
    {
        $fieldValue = $bookID;
        $validateStatus = $this->bookModel->validateBook(fieldValue: $fieldValue);

        if ($validateStatus === true) {
            header('Location: /e-shop/books/edit?BookID=' . $bookID);
            exit();
        }

        $errorAlertMsg = "Error! Book $bookID does not exist";
        $_SESSION['errorAlertMsg'] = $errorAlertMsg;
        header('Location: /e-shop/books');
        exit();
    }

    protected function deleteBook()
    {
        if (isset($_POST['deleteBook']) && is_array($_POST['deleteBook'])) {
            $bookID = array_key_first($_POST['deleteBook']);
        }

        $fieldValue = $bookID;
        $validateStatus = $this->bookModel->validateBook(fieldValue: $fieldValue);

        if ($validateStatus === true) {
            $deleteStatus = $this->bookModel->deleteBook(fieldValue: $fieldValue);

            if ($deleteStatus === true) {
                $successAlertMsg = "Book Deleted";
                $_SESSION['successAlertMsg'] = $successAlertMsg;
                header('Location: /e-shop/books');
                exit();
            }
            $errorAlertMsg = "Error! Cannot Delete Book $fieldValue";
            $_SESSION['errorAlertMsg'] = $errorAlertMsg;
            header('Location: /e-shop/books');
            exit();
        }

        $errorAlertMsg = "Error! Book $bookID does not exist";
        $_SESSION['errorAlertMsg'] = $errorAlertMsg;
        header('Location: /e-shop/books');
        exit();
    }

    public function updateBook()
    {
        if (filter_has_var(INPUT_POST, 'submiteditBook')) {

            $sanitizedInputs = [];

            $sanitizedData = $sanitizedInputs;
            $fieldValue = $_POST['id'];
            var_dump($fieldValue);

            $updateStatus = $this->bookModel->updateBook(sanitizedData: $sanitizedData, fieldValue: $fieldValue);

            if ($updateStatus === true) {
                $successAlertMsg = "Book Record Updated";
                $_SESSION['successAlertMsg'] = $successAlertMsg;
                header('Location: /e-shop/books');
                exit();
            }

            $errorAlertMsg = "Error! Cannot Update Book $fieldValue";
            $_SESSION['errorAlertMsg'] = $errorAlertMsg;
            header('Location: /e-shop/books');
            exit();
        }
    }

    public function searchBook()
    {
        if (filter_has_var(INPUT_POST, 'searchBook')) {

            $searchInput = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $fieldValue = $searchInput;
            $validateStatus = $this->bookModel->validateBook(fieldValue: $fieldValue);

            if ($validateStatus === true) {
                $record = $this->bookModel->retrieveSingleBook(fieldValue: $fieldValue);
                $successAlertMsg = "&#128366; Book:   " . $record['book_id'];
                $_SESSION['successAlertMsg'] = $successAlertMsg;
                header('Location: /e-shop/books');
                exit();
            };
            $errorAlertMsg = "No Book Record found for &#128366; $searchInput";
            $_SESSION['errorAlertMsg'] = $errorAlertMsg;
            header('Location: /e-shop/books');
            exit();
        }
    }
}
