<?php

declare(strict_types=1);

use app\Model\BookModel;

require __DIR__ . '/../../vendor/autoload.php';

// Database Array
$databaseNames = ['eshop', 'backup'];

/** 
 * *************************************************************************************
 * 
 * Add Record to Table
 * 
 * *************************************************************************************
 */
$ID = time();
$newRecord = []; // Record must be passed as an associative array
$tableName = "";
$databaseName = $databaseNames[0];
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
$databaseName = $databaseNames[0];
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
$databaseName = $databaseNames[0];
// $conn = new BookModel(databaseName: $databaseName);
// $result = $conn->retrieveAllBook(tableName: $tableName, fetchMode: "1");
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
$databaseName = $databaseNames[0];
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
$databaseName = $databaseNames[0];
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
$databaseName = $databaseNames[0];
// $conn = new BookModel(databaseName: $databaseName);
// $status = $conn->deleteBook(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
// if ($status) {
//     echo "Deleting record in $tableName returned: " . "true" . PHP_EOL;
// } else {
//     echo "Deleting record in $tableName returned: " . "false" . PHP_EOL;
// }
