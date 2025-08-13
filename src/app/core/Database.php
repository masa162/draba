<?php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = getenv('MYSQL_HOST') ?: 'db';
        $db   = getenv('MYSQL_DATABASE') ?: 'drabaka_db';
        $user = getenv('MYSQL_USER') ?: 'user';
        $pass = getenv('MYSQL_PASSWORD') ?: 'password';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}
