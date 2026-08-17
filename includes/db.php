<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Direct credentials – adjust as needed */
$host    = '127.0.0.1';
$db      = 'burmalab';
$user    = 'root';
$pass    = 'Root@123456!';
$charset = 'utf8mb4';

$dsn = "mysql:host={$host};dbname={$db};charset={$charset}";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    error_log('Database Connection Error: ' . $e->getMessage());
    die('Database Connection Error. Please verify your MySQL credentials.');
}