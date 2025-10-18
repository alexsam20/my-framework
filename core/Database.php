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

    protected array $queries = [];

    public function __construct()
    {
        $dsn = "mysql:host=" . DB['host'] . ";dbname=" . DB['dbname'] . ";charset=" . DB['charset'];
        try {
            $this->dbh = new PDO($dsn, DB['username'], DB['password'], DB['options']);
        } catch (PDOException $e) {
            error_log("[" . date("Y-m-d H:i:s") . "] DB Error: {$e->getMessage()}" . PHP_EOL, 3, ERROR_LOG_PATH);
            abort($e->getMessage(), 500);
        }
    }

    // Prepare statement with query
    public function query($sql): void
    {
        $this->queries[] = $sql;
        $this->stmt = $this->dbh->prepare($sql);
    }

    // Get all records
    public function findAll(string $table): false|array
    {
        $this->query("SELECT * FROM $table WHERE is_deleted IS NULL");
        return $this->resultSet();
    }

    /** TODO Надо разобраться и доделать */
    /* $query .= " where $id = :$id"; */
    public function where($table, $data, $data_not = []): void
    {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "SELECT * FROM $table WHERE ";
        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . " && ";
        }
        foreach ($keys_not as $key) {
            $query .= $key . " != :" . $key . " && ";
        }
        $query = trim($query, " && ");
        $query .= " ORDER BY created_at ASC LIMIT 10 OFFSET 0";
        $data = array_merge($data, $data_not);

        $this->query($query);
        $this->stmt->execute($data);
    }

    // Get one records
    public function findOne(string $table, string $field, mixed $value): false|array
    {
        $this->query("SELECT * FROM $table WHERE $field = :value AND `is_deleted` IS NULL LIMIT 1");
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

    public function insert(string $table, array $attributes = []): false|string
    {
        if (!empty($attributes)) {
            $keys = array_keys($attributes);
            $this->query("INSERT INTO $table (" . implode(',', $keys) . ") 
                   VALUES (" . implode(',', array_map(static fn($attr) => ":$attr", $keys)) . ")");
            foreach ($attributes as $attribute => $value) {
                $this->bind(":$attribute", $value);
            }
            if ($this->execute()) {
                var_dump($this->lastId());
                return $this->lastId();
            }
        }

        return false;
    }

    public function update(string $table, array $attributes = [], string $column = 'id')
    {

        if (!empty($attributes)) {
            $keys = array_keys($attributes);
            $query = "UPDATE $table SET ";

            foreach ($keys as $key) {
                if ($key === $column) {
                    continue;
                }
                $query .= $key . " = :" . $key . ", ";
            }

            $query = trim($query, ", ");
            $query .= " WHERE $column = :$column";
            $this->query($query);
            foreach ($attributes as $attribute => $value) {
                $this->bind(":$attribute", $value);
            }
            if ($this->execute()) {
                return $this->rowCount();
            }

            return false;
        }
        return false;
    }

    // Soft delete
    public function delete(string $table, int $id): false|int
    {
        $attributes = ['id' => $id, 'is_deleted' => date("Y-m-d H:i:s")];
        return $this->update($table, $attributes);

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
    public function execute(): PDOStatement
    {
        $this->stmt->execute();
        if (DEBUG) {
            ob_start();
            $this->stmt->debugDumpParams();
            $this->queries[] = ob_get_clean();
        }
        return $this->stmt;
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
    public function single(): mixed
    {
        $this->execute();

        return $this->stmt->fetch();
    }

    // Get row count
    public function rowCount(): int
    {
        return $this->stmt->rowCount();
    }

    public function getQueries(): array
    {
        $result = [];
        foreach ($this->queries as $key => $query) {
            $line = strtok($query, PHP_EOL);
            while (false !== $line) {
                if (str_contains($line, 'SQL:') || str_contains($line, 'Sent SQL:')) {
                    $result[$key][] = $line;
                }
                $line = strtok(PHP_EOL);
            }
        }
        return $result;
    }
}