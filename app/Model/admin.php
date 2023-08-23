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
$usersTableFields = "`user_id` VARCHAR(20) PRIMARY KEY,
                     `user_name` VARCHAR(150) NOT NULL,
                     `user_email` VARCHAR(150) UNIQUE NOT NULL,
                     `user_password` VARCHAR(255) NOT NULL,
                     `user_address` VARCHAR(150),
                     `user_role` ENUM('ADMIN', 'CUSTOMER') DEFAULT 'CUSTOMER',
                     `user_account_status` ENUM('Active', 'Inactive') DEFAULT 'Active'";

$booksTable = "books";
$booksTableFields = "`book_id` VARCHAR(20) PRIMARY KEY,
                     `book_title` VARCHAR(150) NOT NULL,
                     `book_author` VARCHAR(150) NOT NULL,
                     `book_edition` VARCHAR(10) NOT NULL,
                     `book_price` DECIMAL(10, 2) NOT NULL,
                     `book_qty` INT NOT NULL DEFAULT 0,
                     `book_cover_image` BLOB,
                     `book_publication_date` DATE";

$ordersTable = "orders";
$ordersTableFields = "`order_id` INT PRIMARY KEY,
                      `user_id` VARCHAR(20) NOT NULL,
                      `book_id` VARCHAR(20) NOT NULL,
                      `order_amt` DECIMAL(10, 2) NOT NULL,
                      `order_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                      FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
                      FOREIGN KEY (`book_id`) REFERENCES `books`(`book_id`)";

$cartItemsTable = "cartitems";
$cartItemsTableFields = "`cart_item_id` INT PRIMARY KEY,
                         `user_id` VARCHAR(20) NOT NULL,
                         `book_id` VARCHAR(20) NOT NULL,
                         `cart_item_qty` INT NOT NULL,
                         `cart_item_price` DECIMAL(10, 2) NOT NULL,
                         `cart_item_amt` DECIMAL(10, 2) NOT NULL,
                         FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
                         FOREIGN KEY (`book_id`) REFERENCES `books`(`book_id`)";

$returnedItemsTable = "returns";
$returnedItemsTableFields = "`return_id` INT AUTO_INCREMENT PRIMARY KEY,
                             `user_id` VARCHAR(20) NOT NULL,
                             `book_id` VARCHAR(20) NOT NULL,
                             `order_id` INT NOT NULL,
                             `return_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                             FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`),
                             FOREIGN KEY (`book_id`) REFERENCES `books`(`book_id`),
                             FOREIGN KEY (`order_id`) REFERENCES `orders`(`order_id`)";

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
