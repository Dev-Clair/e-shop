<?php

declare(strict_types=1);

use app\DbResource;
use app\Model\AdminModel;

require_once __DIR__ . '/../../vendor/autoload.php';

// Database Array
$databaseNames = ['eshop', 'backup'];

/**
 * *************************************************************************************
 * 
 * Create / Drop Databases
 * 
 * *************************************************************************************
 */

$databaseName = $databaseNames[0];
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

$tableName = "stock";
$fieldNames = "";
$databaseName = $databaseNames[0];
$conn = new AdminModel(databaseName: $databaseName);
$status = $conn->createTable(tableName: $tableName, fieldNames: $fieldNames);
if ($status) {
    echo "Creating new table `$tableName` in $databaseName returned: " . "true" . PHP_EOL;
} else {
    echo "Creating new table `$tableName` in $databaseName returned: " . "false" . PHP_EOL;
}

$tableName = "sold";
$fieldNames = "`ID` INT PRIMARY KEY,
                `BookID` VARCHAR(20) UNIQUE NOT NULL,
                FOREIGN KEY (`BookID`) REFERENCES stock(`BookID`) ON DELETE CASCADE";
$databaseName =  $databaseNames[0];
$conn = new AdminModel(databaseName: $databaseName);
$status = $conn->createTable(tableName: $tableName, fieldNames: $fieldNames);
if ($status) {
    echo "Creating new table `$tableName` in $databaseName returned: " . "true" . PHP_EOL;
} else {
    echo "Creating new table `$tableName` in $databaseName returned: " . "false" . PHP_EOL;
}

$tableName = "returned";
$fieldNames = "`ID` INT PRIMARY KEY,
                `BookID` VARCHAR(20) UNIQUE NOT NULL,
                FOREIGN KEY (`BookID`) REFERENCES stock(`BookID`) ON DELETE CASCADE";
$databaseName =  $databaseNames[0];
$conn = new AdminModel(databaseName: $databaseName);
$status = $conn->createTable(tableName: $tableName, fieldNames: $fieldNames);
if ($status) {
    echo "Creating new table `$tableName` in $databaseName returned: " . "true" . PHP_EOL;
} else {
    echo "Creating new table `$tableName` in $databaseName returned: " . "false" . PHP_EOL;
}

/** *************************************************************************************
 * 
 * Alter Tables
 * 
 * *************************************************************************************
 */
$databaseName = "";
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
$databaseName = "";
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
$databaseName = "";
$tableName = "";
// $conn = new AdminModel(databaseName: $databaseName);
// $status = $conn->dropTable(tableName: $tableName);
// if ($status) {
//     echo "Deleting table `$tableName` in $databaseName returned: " . "true" . PHP_EOL;
// } else {
//     echo "Deleting table `$tableName` in $databaseName returned: " . "false" . PHP_EOL;
// }
