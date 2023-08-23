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
$book_id = "bk" . time() + 1; // Book ID

$newRecord = [
    'book_id' => $book_id,
    // 'book_title' => 'The Great Gatsby',
    // 'book_author' => 'F. Scott Fitzgerald',
    // 'book_edition' => '1st',
    // 'book_price' => 25.99,
    // 'book_qty' => 50,
    // 'book_cover_image' => null,
    // 'book_publication_date' => '2022-01-15'
    'book_title' => 'To Kill a Mockingbird',
    'book_author' => 'Harper Lee',
    'book_edition' => '2nd',
    'book_price' => 19.95,
    'book_qty' => 30,
    'book_cover_image' => null,
    'book_publication_date' => '2021-08-10'
];

$tableName = "books";
$conn = new BookModel(databaseName: $databaseName);

$status = $conn->createBook(tableName: $tableName, sanitizedData: $newRecord);
if ($status) {
    echo "Creating new record in $tableName returned: " . "true" . PHP_EOL;
} else {
    echo "Creating new record in $tableName returned: " . "false" . PHP_EOL;
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
[
    'The Shining' => 'Stephen King',
    'The Hunger Games' => 'Suzanne Collins',
    'The Great Expectations' => 'Charles Dickens',
    'The Kite Runner' => 'Khaled Hosseini',
    'Lord of the Flies' => 'William Golding',
    'The Giver' => 'Lois Lowry',
    'The Scarlet Letter' => 'Nathaniel Hawthorne',
    'Anna Karenina' => 'Leo Tolstoy',
    'Frankenstein' => 'Mary Shelley',
    'The Outsiders' => 'S.E. Hinton',
    'The Old Man and the Sea' => 'Ernest Hemingway',
    'The Da Vinci Code' => 'Dan Brown',
    'Gone with the Wind' => 'Margaret Mitchell',
    'The Adventures of Huckleberry Finn' => 'Mark Twain',
    'A Tale of Two Cities' => 'Charles Dickens',
    'War and Peace' => 'Leo Tolstoy',
    'Dracula' => 'Bram Stoker',
    'The Little Prince' => 'Antoine de Saint-Exupéry',
    'The Fault in Our Stars' => 'John Green',
    'The Road Not Taken and Other Poems' => 'Robert Frost'
];

[
    'The Count of Monte Cristo' => 'Alexandre Dumas',
    'The Diary of a Young Girl' => 'Anne Frank',
    'The Color Purple' => 'Alice Walker',
    'The Joy Luck Club' => 'Amy Tan',
    'The Book Thief' => 'Markus Zusak',
    'The Handmaid\'s Tale' => 'Margaret Atwood',
    'Wuthering Heights' => 'Emily Brontë',
    'Slaughterhouse-Five' => 'Kurt Vonnegut',
    'The Sun Also Rises' => 'Ernest Hemingway',
    'The Hound of the Baskervilles' => 'Arthur Conan Doyle',
    'Catch-22' => 'Joseph Heller',
    'The Divine Comedy' => 'Dante Alighieri',
    'Heart of Darkness' => 'Joseph Conrad',
    'The Wind in the Willows' => 'Kenneth Grahame',
    'The Name of the Rose' => 'Umberto Eco',
    'The Jungle Book' => 'Rudyard Kipling',
    'The Picture of Dorian Gray' => 'Oscar Wilde',
    'The Prince' => 'Niccolò Machiavelli',
    'The Grapes of Wrath' => 'John Steinbeck',
    'The Secret Garden' => 'Frances Hodgson Burnett'
];

[
    'Pride and Prejudice' => 'Jane Austen',
    'The Hobbit' => 'J.R.R. Tolkien',
    'The Chronicles of Narnia' => 'C.S. Lewis',
    'Jane Eyre' => 'Charlotte Brontë',
    'One Hundred Years of Solitude' => 'Gabriel García Márquez',
    'Fahrenheit 451' => 'Ray Bradbury',
    'Crime and Punishment' => 'Fyodor Dostoevsky',
    'The Road' => 'Cormac McCarthy',
    'The Alchemist' => 'Paulo Coelho',
    'Animal Farm' => 'George Orwell',
    'Gulliver\'s Travels' => 'Jonathan Swift',
    'Moby-Dick' => 'Herman Melville',
    'The Catcher in the Rye' => 'J.D. Salinger',
    'Brave New World' => 'Aldous Huxley',
    'Lord of the Flies' => 'William Golding',
    'The Grapes of Wrath' => 'John Steinbeck',
    'The Picture of Dorian Gray' => 'Oscar Wilde',
    'To Kill a Mockingbird' => 'Harper Lee',
    'The Great Gatsby' => 'F. Scott Fitzgerald',
    'War and Peace' => 'Leo Tolstoy'
];

[
    'The Kite Runner' => 'Khaled Hosseini',
    'Harry Potter and the Sorcerer\'s Stone' => 'J.K. Rowling',
    'The Giver' => 'Lois Lowry',
    'The Scarlet Letter' => 'Nathaniel Hawthorne',
    'Anna Karenina' => 'Leo Tolstoy',
    'Frankenstein' => 'Mary Shelley',
    'The Outsiders' => 'S.E. Hinton',
    'The Adventures of Huckleberry Finn' => 'Mark Twain',
    'A Tale of Two Cities' => 'Charles Dickens',
    'Dracula' => 'Bram Stoker',
    'The Little Prince' => 'Antoine de Saint-Exupéry',
    'The Fault in Our Stars' => 'John Green',
    'The Road Not Taken and Other Poems' => 'Robert Frost',
    'The Shining' => 'Stephen King',
    'The Hunger Games' => 'Suzanne Collins',
    'The Joy Luck Club' => 'Amy Tan',
    'The Book Thief' => 'Markus Zusak',
    'The Handmaid\'s Tale' => 'Margaret Atwood',
    'Wuthering Heights' => 'Emily Brontë',
    'Slaughterhouse-Five' => 'Kurt Vonnegut'
];
