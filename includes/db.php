<?php
/**
 * Database Connection Setup (BurmaLab-Web)
 * Uses PDO with MySQL 8.x and strict exception error handling.
 */

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
} catch (\PDOException $e) {
    // Log exception details in production; display error for local execution
    error_log("Database Connection Error: " . $e->getMessage());
    die("Database Connection Error. Please verify your MySQL credentials and status.");
}