<?php

class Database
{
    private PDO $pdo;
    private object $stmt;

    public function __construct()
    {
        $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try {
            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, $options);
        } catch (PDOException) {
            require_once ERROR_500_PAGE;
            header("Refresh: 2; url=" . PageController::url('login') . "");
        }
    }

    public function query($query)
    {
        $this->stmt = $this->pdo->prepare($query);
    }

    public function bind($param, $value, $type = null)
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

    public function resultset()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute()
    {
        try {
            $this->stmt->execute();
        } catch (PDOException) {
            require_once ERROR_500_PAGE;
            header("Refresh: 2; url=" . PageController::url('login') . "");
        }
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}