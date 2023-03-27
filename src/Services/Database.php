<?php

namespace App\Services;

use PDO;
use PDOException;

class Database
{
    private const DB_HOST = 'localhost';
    private const DB_USER = 'root';
    private const DB_PASS = 'password';
    private const DB_NAME = 'tracking';
    private readonly PDO $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO(
                sprintf("mysql:host=%s;dbname=%s", self::DB_HOST, self::DB_NAME),
                self::DB_USER, self::DB_PASS
            );
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->conn;
    }
}