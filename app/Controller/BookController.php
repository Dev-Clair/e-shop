<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\BookModel;
use app\View\View;

class BookController extends AbsController
{
    public function index()
    {
        $bookModel = new BookModel(databaseName: "books");
        $books = $bookModel->retrieveAllBooks(tableName: "active", fetchMode: "1");

        return View::make('index', [
            'books' => array_slice($books, 0, 50),
            'pageTitle' => 'e-shop Home',
            'searchFormAction' => '/e-shop/search',
            'tableFormAction' => '/e-shop/userAction'
        ]);
    }

    public function create()
    {
        $formAction = '/e-shop/store';
        $pageTitle = "Add Book";
        return View::make('e-shop/create', ['formAction' => $formAction, 'pageTitle' => $pageTitle]);
    }

    public function store()
    {
        if (filter_has_var(INPUT_POST, 'submitcreateBook')) {

            $sanitizedInputs = [];

            $bookModel = new BookModel(databaseName: "books");
            $sanitizedData = $sanitizedInputs;
            $createStatus = $bookModel->createBook(tableName: "active", sanitizedData: $sanitizedData);
            if ($createStatus === true) {
                $successAlertMsg = "New Book Added";
                $_SESSION['successAlertMsg'] = $successAlertMsg;
                header('Location: /e-shop');
                exit();
            }
            $errorAlertMsg = "Error! Cannot Add Book";
            $_SESSION['errorAlertMsg'] = $errorAlertMsg;
            header('Location: /e-shop');
            exit();
        }
    }

    public function edit()
    {
        $bookModel = new BookModel(databaseName: "books");
        $fieldName = "ID";
        $fieldValue = (int)$_GET['BookID'];
        $book = $bookModel->retrieveSingleBook(tableName: "active", fieldName: $fieldName, fieldValue: $fieldValue);
        $formAction = '/books/update';
        $pageTitle = "Update Book";
        return View::make('books/edit', ['book' => $book, 'formAction' => $formAction, 'pageTitle' => $pageTitle]);
    }

    public function userAction()
    {
        if (filter_has_var(INPUT_POST, 'updateBook')) {

            if (isset($_POST['updateBook']) && is_array($_POST['updateBook'])) {
                $bookID = array_key_first($_POST['updateBook']);

                // Retrieve and pass $_POST['updateBook'] value to validateUpdate method
                $this->validateUpdateAction(bookID: $bookID);
            }
        }

        if (filter_has_var(INPUT_POST, 'deleteBook')) {
            $this->delete();
        }
    }

    protected function validateUpdateAction(int|string $bookID)
    {
        $fieldName = "ID";
        $fieldValue = $bookID;
        $booksModel = new BookModel(databaseName: "Books");
        $validateStatus = $booksModel->validateBook(tableName: "active", fieldName: $fieldName, fieldValue: $fieldValue);

        if ($validateStatus === true) {
            header('Location: /books/edit?BookID=' . $bookID);
            exit();
        }

        $errorAlertMsg = "Error! Book $bookID does not exist";
        $_SESSION['errorAlertMsg'] = $errorAlertMsg;
        header('Location: /e-shop');
        exit();
    }

    protected function delete()
    {
        if (isset($_POST['deleteBook']) && is_array($_POST['deleteBook'])) {
            $bookID = array_key_first($_POST['deleteBook']);
        }

        $fieldName = "ID";
        $fieldValue = $bookID;

        $booksModel = new BookModel(databaseName: "Books");

        $validateStatus = $booksModel->validateBook(tableName: "active", fieldName: $fieldName, fieldValue: $fieldValue);

        if ($validateStatus === true) {
            $deleteStatus = $booksModel->deleteBook(tableName: "active", fieldName: $fieldName, fieldValue: $fieldValue);

            if ($deleteStatus === true) {
                $successAlertMsg = "Book Deleted";
                $_SESSION['successAlertMsg'] = $successAlertMsg;
                header('Location: /e-shop');
                exit();
            }
            $errorAlertMsg = "Error! Cannot Delete Book $fieldValue";
            $_SESSION['errorAlertMsg'] = $errorAlertMsg;
            header('Location: /e-shop');
            exit();
        }

        $errorAlertMsg = "Error! Book $bookID does not exist";
        $_SESSION['errorAlertMsg'] = $errorAlertMsg;
        header('Location: /e-shop');
        exit();
    }

    public function update()
    {
        if (filter_has_var(INPUT_POST, 'submiteditBook')) {

            $sanitizedInputs = [];

            $sanitizedData = $sanitizedInputs;
            $fieldName = "ID";
            $fieldValue = $_POST['id'];
            var_dump($fieldValue);

            $booksModel = new BookModel(databaseName: "Books");
            $updateStatus = $booksModel->updateBook(tableName: "active", sanitizedData: $sanitizedData, fieldName: $fieldName, fieldValue: $fieldValue);

            if ($updateStatus === true) {
                $successAlertMsg = "Book Record Updated";
                $_SESSION['successAlertMsg'] = $successAlertMsg;
                header('Location: /e-shop');
                exit();
            }

            $errorAlertMsg = "Error! Cannot Update Book $fieldValue";
            $_SESSION['errorAlertMsg'] = $errorAlertMsg;
            header('Location: /e-shop');
            exit();
        }
    }

    public function search()
    {
        if (filter_has_var(INPUT_POST, 'searchBook')) {
            $booksModel = new bookModel(databaseName: "Books");

            $searchInput = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $fieldName = "BookID";
            $fieldValue = $searchInput;
            $validateStatus = $booksModel->validateBook(tableName: "active", fieldName: $fieldName, fieldValue: $fieldValue);

            if ($validateStatus === true) {
                $record = $booksModel->retrieveSingleBook(tableName: "active", fieldName: $fieldName, fieldValue: $fieldValue);
                $successAlertMsg = "&#9742  Book:   " . $record['BookID'];
                $_SESSION['successAlertMsg'] = $successAlertMsg;
                header('Location: /e-shop');
                exit();
            };
            $errorAlertMsg = "No Book Record found for &#9742 $searchInput";
            $_SESSION['errorAlertMsg'] = $errorAlertMsg;
            header('Location: /e-shop');
            exit();
        }
    }
}
