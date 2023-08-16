<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\UserModel;
use app\Model\BookModel;
use app\Model\CartModel;

class BookController extends AbsController
{
    public function __construct(protected ?UserModel $userModel, protected ?BookModel $bookModel, protected ?CartModel $cartModel)
    {
        parent::__construct($userModel, $bookModel, $cartModel);
    }

    public function index()
    {
        $books = $this->bookModel->retrieveAllBooks(tableName: "books", fetchMode: "1");

        return $this->view::make(
            'index',
            [
                'books' => array_slice($books, 0, 50),
                'pageTitle' => 'e-shop Home',
                'searchFormAction' => '/e-shop/books/search',
                'tableFormAction' => '/e-shop/books/userAction'
            ]
        );
    }

    public function addToCart()
    {
        $this->verifyCustomer() || $this->verifyAdmin();

        $book_id = $_GET['book_id'];

        $user_id = $_SESSION['user_id'];

        $cart_item_id = "crt" . time();

        $book = $this->bookModel->retrieveSingleBook(tableName: "books", fieldName: "book_id", fieldValue: $book_id);

        $sanitizedData = ["cart_item_id"  => $cart_item_id, "user_id" => $user_id, "book_id" => $book_id, "item_qty" => 1, "item_amt" => $book["book_price"]];

        $addToCartStatus = $this->cartModel->createCartItem(sanitizedData: $sanitizedData);

        if ($addToCartStatus) {
            $this->cartAddSuccess(message: "Book added to your cart!");
        } else {
            $this->cartAddError(message: "Failed to add book to your cart!");
        }
    }

    public function newBook()
    {
        $formAction = '/e-shop/store';
        $pageTitle = "Add Book";
        return $this->view::make(
            'e-shop/books/create',
            [
                'formAction' => $formAction,
                'pageTitle' => $pageTitle
            ]
        );
    }

    public function storeBook()
    {
        if (filter_has_var(INPUT_POST, 'submitcreateBook')) {

            $sanitizedInputs = $this->sanitizeUserInput();

            $sanitizedData = $sanitizedInputs;
            $createStatus = $this->bookModel->createBook(sanitizedData: $sanitizedData);
            if ($createStatus === true) {
                $this->successRedirect(message: "New Book Added", redirectTo: "books");
            }
            $this->errorRedirect(message: "Error! Cannot Add Book", redirectTo: "books");
        }
    }

    public function editBook()
    {
        $fieldValue = (int)$_GET['book_id'];
        $book = $this->bookModel->retrieveSingleBook(fieldValue: $fieldValue);
        $formAction = '/e-shop/books/update';
        $pageTitle = "Update Book";
        return $this->view::make(
            '/e-shop/books/edit',
            [
                'book' => $book,
                'formAction' => $formAction,
                'pageTitle' => $pageTitle
            ]
        );
    }

    public function userAction()
    {
        if (filter_has_var(INPUT_POST, 'updateBook')) {

            if (isset($_POST['updateBook']) && is_array($_POST['updateBook'])) {
                $book_id = array_key_first($_POST['updateBook']);

                // Retrieve and pass $_POST['updateBook'] value to validateUpdate method
                $this->validateUpdateBookAction(book_id: $book_id);
            }
        }

        if (filter_has_var(INPUT_POST, 'deleteBook')) {
            $this->deleteBook();
        }
    }

    protected function validateUpdateBookAction(int|string $book_id)
    {
        $fieldValue = $book_id;
        $validateStatus = $this->bookModel->validateBook(fieldValue: $fieldValue);

        if ($validateStatus === true) {
            header('Location: /e-shop/books/edit?book_id=' . $book_id);
            exit();
        }

        $this->errorRedirect(message: "Error! Book $book_id does not exist", redirectTo: "books");
    }

    protected function deleteBook()
    {
        if (isset($_POST['deleteBook']) && is_array($_POST['deleteBook'])) {
            $book_id = array_key_first($_POST['deleteBook']);
        }

        $fieldValue = $book_id;
        $validateStatus = $this->bookModel->validateBook(fieldValue: $fieldValue);

        if ($validateStatus === true) {
            $this->bookModel->deleteBook(fieldValue: $fieldValue)
                ?
                $this->successRedirect(message: "Book Deleted", redirectTo: "books")
                :
                $this->errorRedirect(message: "Error! Cannot Delete Book $fieldValue", redirectTo: "books");
        }

        $this->errorRedirect(message: "Error! Book $book_id does not exist", redirectTo: "books");
    }

    public function updateBook()
    {
        if (filter_has_var(INPUT_POST, 'submiteditBook')) {

            $sanitizedInputs = $this->sanitizeUserInput();

            $sanitizedData = $sanitizedInputs;
            $fieldValue = $_POST['book_id'];

            $this->bookModel->updateBook(sanitizedData: $sanitizedData, fieldValue: $fieldValue)
                ?
                $this->successRedirect(message: "Book Record Updated", redirectTo: "books")
                :
                $this->errorRedirect(message: "Error! Cannot Update Book $fieldValue", redirectTo: "books");
        }
    }

    public function searchBook()
    {
        if (filter_has_var(INPUT_POST, 'searchBook')) {

            $searchInput = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $fieldValue = $searchInput;
            $validateStatus = $this->bookModel->validateBook(fieldName: "book_title", fieldValue: $fieldValue);

            if ($validateStatus) {
                $book_title = $this->bookModel->retrieveBookAttribute(fieldName: "book_title", fieldValue: $fieldValue);
                $message = sprintf("%s", "&#128366; Book: $book_title");
                $this->successRedirect(message: $message, redirectTo: "books");
            };
            $message = sprintf("%s", "No Book Record found for &#128366 $searchInput");
            $this->errorRedirect(message: $message, redirectTo: "books");
        }
    }
}
