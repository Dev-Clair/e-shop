<?php

declare(strict_types=1);

namespace app\Model;

class BookModel extends MainModel
{
    public function __construct(protected ?string $databaseName = null)
    {
        parent::__construct($databaseName);
    }

    public function createBook(string $tableName, array $sanitizedData): bool
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("Invalid table name specified; kindly omit or provide a valid table name.");
        }

        if (empty($sanitizedData)) {
            throw new \InvalidArgumentException("No data specified; kindly provide missing array argument.");
        }

        return $this->dbTableOp->createRecords(tableName: $tableName, sanitizedData: $sanitizedData);
    }

    public function retrieveAllBooks(string $tableName): array
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("Invalid table name specified; kindly omit or provide a valid table name.");
        }

        return $this->dbTableOp->retrieveAllRecords(tableName: $tableName);
    }

    public function retrieveSingleBook(string $tableName, string $fieldName, mixed $fieldValue): array
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

        return $this->dbTableOp->retrieveSpecificRecord_firstOccurrence(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }

    public function retrieveBookAttribute(string $tableName, string $fieldName, string $compareFieldName, mixed $compareFieldValue): mixed
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

    public function validateBook(string $tableName, string $fieldName, mixed $fieldValue): bool
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

        return $this->dbTableOp->validateRecord(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }

    public function searchBook(string $tableName, string $fieldName, mixed $fieldValue): array
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

    public function updateBook(string $tableName, array $sanitizedData, string $fieldName, mixed $fieldValue): bool
    {
        if (empty($tableName)) {
            throw new \InvalidArgumentException("Invalid table name specified; kindly omit or provide a valid table name.");
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

    public function deleteBook(string $tableName, string $fieldName, mixed $fieldValue): bool
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

        return $this->dbTableOp->deleteRecord(tableName: $tableName, fieldName: $fieldName, fieldValue: $fieldValue);
    }
}
