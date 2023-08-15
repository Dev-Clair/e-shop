<?php

declare(strict_types=1);

namespace app\Controller;

use app\Model\BookModel;
use app\View\View;

class BookController extends AbsController
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


            $sanitizedData = $sanitizedInputs;
            $createStatus = $this->bookModel->createBook(tableName: "books", sanitizedData: $sanitizedData);
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
        $fieldName = "ID";
        $fieldValue = (int)$_GET['BookID'];
        $book = $this->bookModel->retrieveSingleBook(tableName: "books", fieldName: $fieldName, fieldValue: $fieldValue);
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
        $validateStatus = $this->bookModel->validateBook(tableName: "books", fieldName: $fieldName, fieldValue: $fieldValue);

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


        $validateStatus = $this->bookModel->validateBook(tableName: "active", fieldName: $fieldName, fieldValue: $fieldValue);

        if ($validateStatus === true) {
            $deleteStatus = $this->bookModel->deleteBook(tableName: "active", fieldName: $fieldName, fieldValue: $fieldValue);

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

            $updateStatus = $this->bookModel->updateBook(tableName: "books", sanitizedData: $sanitizedData, fieldName: $fieldName, fieldValue: $fieldValue);

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

            $searchInput = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $fieldName = "BookID";
            $fieldValue = $searchInput;
            $validateStatus = $this->bookModel->validateBook(tableName: "active", fieldName: $fieldName, fieldValue: $fieldValue);

            if ($validateStatus === true) {
                $record = $this->bookModel->retrieveSingleBook(tableName: "active", fieldName: $fieldName, fieldValue: $fieldValue);
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
