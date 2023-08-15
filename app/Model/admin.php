<?php

declare(strict_types=1);

use app\DbResource;
use app\Model\AdminModel;

require_once __DIR__ . '/../../vendor/autoload.php';

// Database Array
$databaseNames = ['eshop', 'backup'];
$databaseName = $databaseNames[0];

/**
 * *************************************************************************************
 * 
 * Create / Drop Databases
 * 
 * *************************************************************************************
 */

$dbConn = DbResource::dbConn($databaseName);

if (!$dbConn instanceof \PDO) {
    throw new \RuntimeException('Connection failed.');
}

$sql_query = "CREATE DATABASE IF NOT EXISTS $databaseName";
// $sql_query = "DROP DATABASE $databaseName";

if ($dbConn->query($sql_query)) {
    echo "Database operation was successful" . PHP_EOL;
} else {
    throw new \RuntimeException('Database operation failed' . PHP_EOL);
}

/**
 * *************************************************************************************
 * 
 * Create Tables
 * 
 * *************************************************************************************
 */

$usersTable = "users";
$usersTableFields = "`userID` INT PRIMARY KEY,
                     `name` VARCHAR(150) NOT NULL,
                     `email` VARCHAR(150) UNIQUE NOT NULL,
                     `password` VARCHAR(255) NOT NULL,
                     `role` ENUM('ADMIN', 'CUSTOMER') DEFAULT 'CUSTOMER'";

$booksTable = "books";
$booksTableFields = "`bookID` INT PRIMARY KEY,
                     `title` VARCHAR(150) NOT NULL,
                     `author` VARCHAR(150) NOT NULL,
                     `description` TEXT NOT NULL,
                     `price` DECIMAL(10, 2) NOT NULL,
                     `coverImage` BLOB,
                     `publicationDate` DATE";

$ordersTable = "orders";
$ordersTableFields = "`orderID` INT PRIMARY KEY,
                      `userID` INT NOT NULL,
                      `orderQty` INT NOT NULL,
                      `orderAmt` DECIMAL(10, 2) NOT NULL,
                      `orderDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                      FOREIGN KEY (`userID`) REFERENCES users(`userID`)";

$cartItemsTable = "cartitems";
$cartItemsTableFields = "`cartItemID` INT AUTO_INCREMENT PRIMARY KEY,
                         `userID` INT NOT NULL,
                         `bookID` INT NOT NULL,
                         `cartQty` INT NOT NULL,
                         `cartAmt` DECIMAL(10, 2) NOT NULL,
                         FOREIGN KEY (`userID`) REFERENCES users(`userID`),
                         FOREIGN KEY (`bookID`) REFERENCES books(`bookID`)";


$returnedItemsTable = "returns";
$returnedItemsTableFields = "`returnID` INT AUTO_INCREMENT PRIMARY KEY,
                             `userID` INT NOT NULL,
                             `orderID` INT NOT NULL,
                             `returnDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                             FOREIGN KEY (`userID`) REFERENCES users(`userID`),
                             FOREIGN KEY (`orderID`) REFERENCES orders(`orderID`)";

$databaseTables = [
    $usersTable => $usersTableFields,
    $booksTable => $booksTableFields,
    $ordersTable => $ordersTableFields,
    $cartItemsTable => $cartItemsTableFields,
    $returnedItemsTable => $returnedItemsTableFields
];

$conn = new AdminModel(databaseName: $databaseName);
foreach ($databaseTables as $tableName => $fieldNames) {
    $status = $conn->createTable(tableName: $tableName, fieldNames: $fieldNames);
    if ($status) {
        echo "Creating new table `$tableName` in $databaseName returned: " . "true" . PHP_EOL;
    } else {
        echo "Creating new table `$tableName` in $databaseName returned: " . "false" . PHP_EOL;
    }
}

/** *************************************************************************************
 * 
 * Alter Tables
 * 
 * *************************************************************************************
 */
$tableName = "";
$alterStatement = "ADD COLUMN ``  NOT NULL FIRST";
// $conn = new AdminModel(databaseName: $databaseName);
// $status = $conn->alterTable(tableName: $tableName, alterStatement: $alterStatement);
// if ($status) {
//     echo "Modifying $tableName table in $databaseName returned: " . "true" . PHP_EOL;
// } else {
//     echo "Modifying $tableName table in $databaseName returned: " . "false" . PHP_EOL;
// }

/** 
 * *************************************************************************************
 * 
 * Truncate Tables
 * 
 * *************************************************************************************
 */
$tableName = "";
// $conn = new AdminModel(databaseName: $databaseName);
// $status = $conn->truncateTable(tableName: $tableName);
// if ($status) {
//     echo "Clearing all $tableName records in $databaseName returned: " . "true" . PHP_EOL;
// } else {
//     echo "Clearing all $tableName records in $databaseName returned: " . "false" . PHP_EOL;
// }

/** 
 * *************************************************************************************
 * 
 * Drop Tables
 * 
 * *************************************************************************************
 */
$tableName = "";
// $conn = new AdminModel(databaseName: $databaseName);
// $status = $conn->dropTable(tableName: $tableName);
// if ($status) {
//     echo "Deleting table `$tableName` in $databaseName returned: " . "true" . PHP_EOL;
// } else {
//     echo "Deleting table `$tableName` in $databaseName returned: " . "false" . PHP_EOL;
// }
