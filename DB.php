<?php

class DB
{
    public $conn = null;

    public function __construct($hostname, $username, $password, $db_name)
    {
        try {
            $dsn = "mysql:host=$hostname;dbname=$db_name;";
            $this->conn = new PDO($dsn, $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Error - " . $e->getMessage();
        }
    }

    public function insert($statement, $params)
    {
        try {
            $this->executeStatment($statement, $params);
            return  $this->conn->lastInsertId();
        } catch (PDOException $e) {
            echo "Insert Error - " . $e->getMessage();
        }
    }

    public function update($statement, $params)
    {
        try {
            return $this->executeStatment($statement, $params);;
        } catch (PDOException $e) {
            echo "Insert Error - " . $e->getMessage();
        }
    }

    public function select($statement)
    {
        try {
            $result = $this->conn->query($statement);
            return $result->fetchAll();
        } catch (PDOException $e) {
            echo "Select Error - " . $e->getMessage();
        }
    }


    public function selectOne($statement)
    {
        try {
            $result = $this->conn->query($statement);
            return $result->fetch();
        } catch (PDOException $e) {
            echo "Select Error - " . $e->getMessage();
        }
    }

    public function delete($statement)
    {
        try {
            return $this->conn->exec($statement);
        } catch (PDOException $e) {
            echo "Delete Error - " . $e->getMessage();
        }
    }

    private function executeStatment($statement, $params): bool
    {
        $stmt = $this->conn->prepare($statement);
        return $stmt->execute($params);
    }
}
