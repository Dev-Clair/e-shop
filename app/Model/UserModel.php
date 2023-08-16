<?php

declare(strict_types=1);

namespace app\Model;

class UserModel extends MainModel
{
    public function __construct(protected ?string $databaseName = null)
    {
        parent::__construct($databaseName);
    }

    public function createUser(string $tableName = "users", array $sanitizedData): bool
    {
        if (empty($sanitizedData)) {
            throw new \InvalidArgumentException("No data specified; kindly provide missing array argument.");
        }

        return $this->dbTableOp->createRecords(tableName: $tableName, sanitizedData: $sanitizedData);
    }

    public function retrieveAllUsers(string $tableName = "users", string $fetchMode = "1"): array
    {
        return $this->dbTableOp->retrieveAllRecords(tableName: $tableName, fetchMode: $fetchMode);
    }

    public function retrieveSingleUser(string $tableName = "users", string $fieldName = "user_id", mixed $fieldValue): array
    {
        if (empty($fieldValue)) {
            throw new \InvalidArgumentException("No field value specified; kindly provide reference field value.");
        }

        $fieldName = "`$fieldName`";

        return $this->dbTableOp->retrieveSingleRecord(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }

    public function retrieveUserValue(string $tableName = "users", string $fieldName = "user_id", mixed $fieldValue): mixed
    {
        if (empty($fieldValue)) {
            throw new \InvalidArgumentException("No field value specified; kindly provide reference field value.");
        }

        $fieldName = "`$fieldName`";

        return $this->dbTableOp->retrieveSingleValue(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }

    public function validateUser(string $tableName = "users", string $fieldName = "user_id", mixed $fieldValue): bool
    {
        if (empty($fieldValue)) {
            throw new \InvalidArgumentException("No field value specified; kindly provide reference field value.");
        }

        $fieldName = "`$fieldName`";

        return $this->dbTableOp->validateRecord(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }

    public function updateUser(string $tableName = "users", array $sanitizedData, string $fieldName = "user_id", mixed $fieldValue): bool
    {
        if (empty($sanitizedData)) {
            throw new \InvalidArgumentException("No data specified; kindly provide missing array argument.");
        }

        if (empty($fieldValue)) {
            throw new \InvalidArgumentException("No field value specified; kindly provide reference field value.");
        }

        $fieldName = "`$fieldName`";

        return $this->dbTableOp->updateRecord(tableName: $tableName, sanitizedData: $sanitizedData, fieldName: $fieldName, fieldValue: $fieldValue);
    }

    public function deleteUser(string $tableName = "users", string $fieldName = "user_id", mixed $fieldValue): bool
    {
        if (empty($fieldValue)) {
            throw new \InvalidArgumentException("No field value specified; kindly provide reference field value.");
        }

        $fieldName = "`$fieldName`";

        return $this->dbTableOp->deleteRecord(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }
}
