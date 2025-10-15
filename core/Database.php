<?php

namespace core;

use PDO;
use PDOException;
use PDOStatement;

class Database
{

    /**
     * @var PDO
     */
    private PDO $dbh;
    /**
     * @var PDOStatement
     */
    private PDOStatement $stmt;

    public function __construct()
    {
        $dsn = "mysql:host=" . DB['host'] . ";dbname=" . DB['dbname'] . ";charset=" . DB['charset'];
        try {
            $this->dbh = new PDO($dsn, DB['username'], DB['password'], DB['options']);
        } catch (PDOException $e) {
            abort($e->getMessage(), 500);
        }
    }

    // Prepare statement with query
    public function query($sql): void
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Get all records
    public function findAll(string $table): false|array
    {
        $this->query("SELECT * FROM $table");
        return $this->resultSet();
    }

    // Get one records
    public function findOne(string $table, string $field, mixed $value): false|array
    {
        $this->query("SELECT * FROM $table WHERE $field = :value LIMIT 1");
        $this->bind(':value', $value);

        return $this->single();
    }

    // Get One record or error 404
    public function findOrFail(string $table, string $field, mixed $value): false|array
    {
        $result = $this->findOne($table, $field, $value);
        if ($result === false) { abort(); }

        return $result;
    }

    // Bind values
    public function bind(string $param, mixed $value, $type = null): void
    {
        if (is_null($type)) {
            $type = match (true) {
                is_int($value) => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                is_null($value) => PDO::PARAM_NULL,
                default => PDO::PARAM_STR,
            };
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute the prepared statement
    public function execute(): bool
    {
        return $this->stmt->execute();
    }

    // Get result set as array of objects
    public function resultSet(): false|array
    {
        $this->execute();

        return $this->stmt->fetchAll();
    }

    // Get id last record.
    public function lastId(): false|string
    {
        return $this->dbh->lastInsertId();
    }

    // Get single record as object
    public function single()
    {
        $this->execute();

        return $this->stmt->fetch();
    }

    // Get row count
    public function rowCount(): int
    {
        return $this->stmt->rowCount();
    }
}