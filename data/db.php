<?php
$dsn = 'mysql:host=localhost;dbname=record_store;charset=utf8mb4';
$user = 'root';
$pass = '';
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (Exception $e) {
    die('Database connection failed: ' . $e->getMessage());
}
return $pdo;
?>