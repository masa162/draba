<?php
require_once '/var/www/html/app/core/Database.php';
$pdo = Database::getInstance()->getConnection();
$stmt = $pdo->query('SELECT COUNT(*) FROM dramas');
echo $stmt->fetchColumn();
