<?php

declare(strict_types=1);

namespace app\Model;

class UserModel extends MainModel
{
    public function __construct(protected ?string $databaseName = null)
    {
        parent::__construct($databaseName);
    }

    public function createUser(string $tableName, array $sanitizedData): bool
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("Invalid table name specified; kindly omit or provide a valid table name.");
        }

        if (empty($sanitizedData)) {
            throw new \InvalidArgumentException("No data specified; kindly provide missing array argument.");
        }

        return $this->dbTableOp->createRecords(tableName: $tableName, sanitizedData: $sanitizedData);
    }

    public function retrieveAllUsers(string $tableName): array
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("Invalid table name specified; kindly omit or provide a valid table name.");
        }

        return $this->dbTableOp->retrieveAllRecords(tableName: $tableName);
    }

    public function retrieveSingleUser(string $tableName, string $fieldName, mixed $fieldValue): array
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("Invalid table name specified; kindly provide a valid table name.");
        }

        if (empty($fieldName)) {
            throw new \InvalidArgumentException("Invalid fieldname specified; kindly provide reference field name.");
        }

        if (empty($fieldValue)) {
            throw new \InvalidArgumentException("No field value specified; kindly provide reference field value.");
        }

        $fieldName = "`$fieldName`";

        return $this->dbTableOp->retrieveSpecificRecord_firstOccurrence(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }

    public function retrieveUserAttribute(string $tableName, string $fieldName, string $compareFieldName, mixed $compareFieldValue): mixed
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("Invalid table name specified; kindly provide a valid table name.");
        }

        if (empty($fieldName)) {
            throw new \InvalidArgumentException("No field name specified; kindly provide reference field name.");
        }

        if (empty($compareFieldName)) {
            throw new \InvalidArgumentException("No field name specified; kindly provide reference field value.");
        }

        if (empty($compareFieldValue)) {
            throw new \InvalidArgumentException("No field value specified; kindly provide reference field value.");
        }

        $fieldName = "`$fieldName`";

        return $this->dbTableOp->retrieveSingleValue(tableName: $tableName, fieldName: $fieldName, compareFieldName: $compareFieldName, compareFieldValue: $compareFieldValue);
    }

    public function validateUser(string $tableName, string $fieldName, mixed $fieldValue): bool
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("Invalid table name specified; kindly provide a valid table name.");
        }

        if (empty($fieldName)) {
            throw new \InvalidArgumentException("No field name specified; kindly provide reference field name.");
        }

        if (empty($fieldValue)) {
            throw new \InvalidArgumentException("No field value specified; kindly provide reference field value.");
        }

        $fieldName = "`$fieldName`";

        return $this->dbTableOp->validateRecord(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }

    public function searchUser(string $tableName, string $fieldName, mixed $fieldValue): array
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("Invalid table name specified; kindly omit or provide a valid table name.");
        }

        if (empty($fieldName)) {
            throw new \InvalidArgumentException("No field name specified; kindly provide reference field name.");
        }

        if (empty($fieldValue)) {
            throw new \InvalidArgumentException("No field value specified; kindly provide reference field value.");
        }

        $fieldName = "`$fieldName`";

        return $this->dbTableOp->searchRecord(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }

    public function updateUser(string $tableName, array $sanitizedData, string $fieldName, mixed $fieldValue): bool
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("Invalid table name specified; kindly provide a valid table name.");
        }

        if (empty($sanitizedData)) {
            throw new \InvalidArgumentException("No data specified; kindly provide missing array argument.");
        }

        if (empty($fieldName)) {
            throw new \InvalidArgumentException("No field name specified; kindly provide reference field name.");
        }

        if (empty($fieldValue)) {
            throw new \InvalidArgumentException("No field value specified; kindly provide reference field value.");
        }

        $fieldName = "`$fieldName`";

        return $this->dbTableOp->updateRecord(tableName: $tableName, sanitizedData: $sanitizedData, fieldName: $fieldName, fieldValue: $fieldValue);
    }

    public function deleteUser(string $tableName, string $fieldName, mixed $fieldValue): bool
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("Invalid table name specified; kindly provide a valid table name.");
        }

        if (empty($fieldName)) {
            throw new \InvalidArgumentException("No field name specified; kindly provide reference field name.");
        }

        if (empty($fieldValue)) {
            throw new \InvalidArgumentException("No field value specified; kindly provide reference field value.");
        }

        $fieldName = "`$fieldName`";

        return $this->dbTableOp->deleteRecord(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }
}
