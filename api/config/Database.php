<?php

class Database
{
    //DB params
    private $dsn = 'mysql:host=localhost;dbname=aroma_db;port=3308';
    private $username = "root";
    private $password = "";
    private $conn;

    //DB connect
    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                $this->dsn,
                $this->username,
                $this->password
            );
            //set error mode
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
        return $this->conn;
    }
}
