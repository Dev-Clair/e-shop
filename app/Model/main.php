<?php

declare(strict_types=1);

use app\Model\BookModel;

require __DIR__ . '/../../vendor/autoload.php';

// Database Array
$databaseNames = ['eshop', 'backup'];
$databaseName = $databaseNames[0];

/** 
 * *************************************************************************************
 * 
 * Add Record to Table
 * 
 * *************************************************************************************
 */

// Book title and authors
[
    'The Great Gatsby' => 'F. Scott Fitzgerald',
    'To Kill a Mockingbird' => 'Harper Lee',
    '1984' => 'George Orwell',
    'Pride and Prejudice' => 'Jane Austen',
    'The Catcher in the Rye' => 'J.D. Salinger',
    'Brave New World' => 'Aldous Huxley',
    'The Lord of the Rings' => 'J.R.R. Tolkien',
    'Harry Potter and the Sorcerer\'s Stone' => 'J.K. Rowling',
    'The Hobbit' => 'J.R.R. Tolkien',
    'The Chronicles of Narnia' => 'C.S. Lewis',
    'To the Lighthouse' => 'Virginia Woolf',
    'Moby-Dick' => 'Herman Melville',
    'The Grapes of Wrath' => 'John Steinbeck',
    'The Picture of Dorian Gray' => 'Oscar Wilde',
    'Jane Eyre' => 'Charlotte Brontë',
    'One Hundred Years of Solitude' => 'Gabriel García Márquez',
    'Fahrenheit 451' => 'Ray Bradbury',
    'Crime and Punishment' => 'Fyodor Dostoevsky',
    'The Road' => 'Cormac McCarthy',
    'The Alchemist' => 'Paulo Coelho'
];

$newBooks = [
    [
        'book_id' => "bk" . time(),
        'book_title' => 'The Great Gatsby',
        'book_author' => 'F. Scott Fitzgerald',
        'book_edition' => '1st',
        'book_price' => 25.99,
        'book_qty' => 50,
        'book_cover_image' => null,
        'book_publication_date' => '2022-01-15'
    ],
    [
        'book_id' => "bk" . time(),
        'book_title' => 'To Kill a Mockingbird',
        'book_author' => 'Harper Lee',
        'book_edition' => '2nd',
        'book_price' => 19.95,
        'book_qty' => 30,
        'book_cover_image' => null,
        'book_publication_date' => '2021-08-10'
    ],
    [
        'book_id' => "bk" . time(),
        'book_title' => '',
        'book_author' => '',
        'book_edition' => '2nd',
        'book_price' => 10.05,
        'book_qty' => 20,
        'book_cover_image' => null,
        'book_publication_date' => '2018-07-11'
    ],
    [
        'book_id' => "bk" . time(),
        'book_title' => '',
        'book_author' => '',
        'book_edition' => '4th',
        'book_price' => 39.95,
        'book_qty' => 15,
        'book_cover_image' => null,
        'book_publication_date' => '2016-12-03'
    ]
];

$tableName = "books";
$conn = new BookModel(databaseName: $databaseName);

foreach ($newBooks as $book) {
    $status = $conn->createBook(tableName: $tableName, sanitizedData: $book);
    if ($status) {
        echo "Creating new record in $tableName returned: " . "true" . PHP_EOL;
    } else {
        echo "Creating new record in $tableName returned: " . "false" . PHP_EOL;
    }
}

/**
 * *************************************************************************************
 * 
 * Validate Record
 * 
 * *************************************************************************************
 */
$fieldName = "";
$fieldValue = "";

$tableName = "";
// $conn = new BookModel(databaseName: $databaseName);
// $status = $conn->validateBook(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
// if ($status) {
//     echo "Validating record in $tableName returned: " . "true" . PHP_EOL;
// } else {
//     echo "Validating record in $tableName returned: " . "false" . PHP_EOL;
// }

/**
 * *************************************************************************************
 * 
 * Retrieve All Table Records
 * 
 * *************************************************************************************
 */
$tableName = "";
// $conn = new BookModel(databaseName: $databaseName);
// $result = $conn->retrieveAllBooks(tableName: $tableName, fetchMode: "1");
// echo "Retrieving all records in $tableName: " . PHP_EOL;
// var_dump($result);

/**
 * *************************************************************************************
 * 
 * Retrieve Single Table Record
 * 
 * *************************************************************************************
 */
$fieldName = "";
$fieldValue = "";

$tableName = "";
// $conn = new BookModel(databaseName: $databaseName);
// $result = $conn->retrieveSingleBook(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
// echo "Retrieving single record in $tableName: " . PHP_EOL;
// var_dump($result);

/**
 * *************************************************************************************
 * 
 * Update Table Record
 * 
 * *************************************************************************************
 */
$record = []; // Record must be passed as an associative array
$fieldName = "";
$fieldValue = "";

$tableName = "";
// $conn = new BookModel(databaseName: $databaseName);
// $status = $conn->updateBook(tableName: $tableName, sanitizedData: $record, fieldName: $fieldName, fieldValue: $fieldValue);
// if ($status) {
//     echo "Updating record in $tableName returned: " . "true" . PHP_EOL;
// } else {
//     echo "Updating record in $tableName returned: " . "false" . PHP_EOL;
// }

/**
 * *************************************************************************************
 * 
 * Delete Table Record
 * 
 * *************************************************************************************
 */
$fieldName = "";
$fieldValue = "";

$tableName = "";
// $conn = new BookModel(databaseName: $databaseName);
// $status = $conn->deleteBook(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
// if ($status) {
//     echo "Deleting record in $tableName returned: " . "true" . PHP_EOL;
// } else {
//     echo "Deleting record in $tableName returned: " . "false" . PHP_EOL;
// }
