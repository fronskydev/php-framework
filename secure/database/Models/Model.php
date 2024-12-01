<?php

namespace database\Models;

use database\Exception\DatabaseException;
use database\Utils\QueryBuilder;
use Doctrine\DBAL\Exception;

abstract class Model
{
    protected string $table;
    protected QueryBuilder $queryBuilder;
    private int $lastInsertedId;

    /**
     * Constructor of the class.
     *
     * Initializes a new QueryBuilder instance and checks if the 'table' property is defined in the model.
     * Throws a DatabaseException if the 'table' property is not defined.
     *
     * @throws DatabaseException If the 'table' property is not defined in the model.
     */
    public function __construct() {
        $this->queryBuilder = new QueryBuilder();
        if (!$this->table) {
            throw new DatabaseException("Model table not defined");
        }
    }

    /**
     * Create a new record in the database table using the provided data.
     *
     * @param array $data An associative array containing the data to be inserted into the database table,
     *                    where keys represent column names and values represent corresponding values.
     */
    public function create(array $data): void
    {
        try {
            $this->queryBuilder
                ->insert($this->table, $data)
                ->execute();
            $this->lastInsertedId = $this->queryBuilder->getLastInsertedId();
        } catch (Exception $exception) {}
    }

    /**
     * Find a record in the database table by the provided ID.
     *
     * @param int $id The ID of the record to search for in the database table.
     *
     * @return array An associative array representing the found record in the database, or an empty array if the record is not found.
     */
    public function find(int $id): array
    {
        try {
            $result = $this->queryBuilder
                ->select($this->table)
                ->where("id", "=", $id)
                ->execute();

            if (empty($result)) {
                return array();
            }
            return $result[0];
        } catch (Exception $exception) {
            return array();
        }
    }

    /**
     * Find records in the database table by the provided column and value.
     *
     * @param string $column The column name to search in the database table.
     * @param mixed $value The value to match in the specified column.
     *
     * @return array An array of associative arrays representing the found records in the database, or an empty array if no records are found.
     */
    public function findBy(string $column, mixed $value): array
    {
        try {
            return $this->queryBuilder
                ->select($this->table)
                ->where($column, "=", $value)
                ->execute();
        } catch (Exception $exception) {
            return array();
        }
    }

    /**
     * Update a record in the database table based on the provided ID and data.
     *
     * @param int $id The ID of the record to be updated in the database table.
     * @param array $data An associative array containing the data to be updated in the database table,
     *                    where keys represent column names and values represent corresponding new values.
     */
    public function update(int $id, array $data): void
    {
        try {
            $this->queryBuilder
                ->update($this->table, $data)
                ->where("id", "=", $id)
                ->execute();
        } catch (Exception $exception) {}
    }

    /**
     * Update records in the database table based on the provided column and value.
     *
     * @param string $column The column name to search in the database table.
     * @param mixed $value The value to match in the specified column.
     * @param array $data An associative array containing the data to be updated in the database table,
     *                    where keys represent column names and values represent corresponding new values.
     */
    public function updateBy(string $column, mixed $value, array $data): void
    {
        try {
            $this->queryBuilder
                ->update($this->table, $data)
                ->where($column, "=", $value)
                ->execute();
        } catch (Exception $exception) {}
    }

    /**
     * Delete a record from the database table based on the provided ID.
     *
     * @param int $id The ID of the record to be deleted from the database table.
     */
    public function delete(int $id): void
    {
        try {
            $this->queryBuilder
                ->delete($this->table)
                ->where("id", "=", $id)
                ->execute();
        } catch (Exception $exception) {}
    }

    /**
     * Delete records from the database table based on the provided column and value.
     *
     * @param string $column The column name to search in the database table.
     * @param mixed $value The value to match in the specified column.
     */
    public function deleteBy(string $column, mixed $value): void
    {
        try {
            $this->queryBuilder
                ->delete($this->table)
                ->where($column, "=", $value)
                ->execute();
        } catch (Exception $exception) {}
    }

    /**
     * Retrieve all records from the database table.
     *
     * @return array An array of associative arrays representing all records retrieved from the database,
     *               or an empty array if no records are found.
     */
    public function all(): array
    {
        try {
            return $this->queryBuilder
                ->select($this->table)
                ->execute();
        } catch (Exception $exception) {
            return array();
        }
    }

    /**
     * Perform a custom query on the database.
     *
     * @param string $query The SQL query to be executed on the database.
     *
     * @return array An array of associative arrays representing the result of the executed query,
     *               or an empty array if no records are found.
     */
    public function query(string $query): array {
        try {
            return $this->queryBuilder
                ->raw($query)
                ->execute();
        } catch (Exception $exception) {
            return array();
        }
    }

    /**
     * Retrieves the last inserted ID from the database.
     *
     * @return int The last inserted ID.
     */
    public function getLastInsertedId(): int
    {
        return $this->lastInsertedId;
    }
}