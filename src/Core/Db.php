<?php

namespace Bulbakh\Telenorma\Core;

use PDO;
use PDOException;

class Db
{
    private ?PDO $connection;

    /**
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database
     */
    public function __construct(string $host, string $username, string $password, string $database)
    {
        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function __destruct()
    {
        $this->closeConnection();
    }

    /**
     * @param string $table
     * @param array $data
     * @return bool
     */
    public function insert(string $table, array $data): bool
    {
        $keys = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO $table ($keys) VALUES ($values)";
        $statement = $this->connection->prepare($query);

        foreach ($data as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }

        return $statement->execute();
    }

    /**
     * @param string $table
     * @param array $conditions
     * @return bool|array
     */
    public function select(string $table, array $conditions = []): bool|array
    {
        $query = "SELECT * FROM $table ";
        if (!empty($conditions)) {
            $where = [];
            foreach ($conditions as $field => $value) {
                $where[] = $field . ' = ' . $value;
            }
            $query .= " WHERE " . implode(',', $where);
        }

        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $table
     * @param array $data
     * @param array $conditions
     * @return bool
     */
    public function update(string $table, array $data, array $conditions): bool
    {
        $set = '';
        foreach (array_keys($data) as $key) {
            $set .= "$key = :$key, ";
        }
        $set = rtrim($set, ', ');

        $where = [];
        foreach ($conditions as $field => $value) {
            $where[] = $field . ' = ' . $value;
        }
        $where = " WHERE " . implode(',', $where);

        $query = "UPDATE $table SET $set $where";
        $statement = $this->connection->prepare($query);

        foreach ($data as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }

        return $statement->execute();
    }

    /**
     * @param string $table
     * @param array $conditions
     * @return bool
     */
    public function delete(string $table, array $conditions): bool
    {
        $where = [];
        foreach ($conditions as $field => $value) {
            $where[] = $field . ' = ' . $value;
        }
        $where = implode(',', $where);

        $query = "DELETE FROM $table WHERE $where ";
        $statement = $this->connection->prepare($query);

        return $statement->execute();
    }

    /**
     * @param string $query
     * @return bool|array
     */
    public function execute(string $query): bool|array
    {
        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function closeConnection(): void
    {
        $this->connection = null;
    }
}
