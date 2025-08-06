<?php

$host = getenv('MYSQL_HOST');
$db   = getenv('MYSQL_DATABASE');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_PASSWORD');
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "<h1>Success: Connected to MariaDB!</h1>";
    echo "<p>PHP version: " . phpversion() . "</p>";

} catch (\PDOException $e) {
    echo "<h1>Error: Connection Failed</h1>";
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

?>
