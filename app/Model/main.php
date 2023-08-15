<?php

declare(strict_types=1);

use app\Model\UserModel;

require __DIR__ . '/../../vendor/autoload.php';

// Database Array
$databaseNames = ['eshop', 'backup'];
$databseName = $databaseNames[0];

/** 
 * *************************************************************************************
 * 
 * Add Record to Table
 * 
 * *************************************************************************************
 */
$admin_id = "adm" . time(); // Admin User
// $customer_id = "cus" . time(); // Customer User

$user_password = password_hash(password: readline("Enter Password: "), algo: PASSWORD_BCRYPT); // Admin or Customer

$newRecord = [
    "user_id" => $admin_id, "user_name" => "Samuel Aniogbu", "user_email" => "aniogbu.samuel@yahoo.com", "user_password" => $user_password, "user_role" => "ADMIN"
];

// $newRecord = [
//     "user_id" => $customer_id, "user_name" => "Wendy Uche", "user_email" => "uche.wendy@yahoo.com", "user_password" => $user_password
// ];

$tableName = "users";
$conn = new UserModel(databaseName: $databaseName);

$status = $conn->createUser(tableName: $tableName, sanitizedData: $newRecord);
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
// $conn = new UserModel(databaseName: $databaseName);
// $status = $conn->validateUser(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
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
// $conn = new UserModel(databaseName: $databaseName);
// $result = $conn->retrieveAllUsers(tableName: $tableName, fetchMode: "1");
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
// $conn = new UserModel(databaseName: $databaseName);
// $result = $conn->retrieveSingleUser(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
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
// $conn = new UserModel(databaseName: $databaseName);
// $status = $conn->updateUser(tableName: $tableName, sanitizedData: $record, fieldName: $fieldName, fieldValue: $fieldValue);
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
// $conn = new UserModel(databaseName: $databaseName);
// $status = $conn->deleteUser(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
// if ($status) {
//     echo "Deleting record in $tableName returned: " . "true" . PHP_EOL;
// } else {
//     echo "Deleting record in $tableName returned: " . "false" . PHP_EOL;
// }
