<?php
// Database configuration
$host = 'localhost';
$db   = 'school_db';
$user = 'root';
$pass = '';
$char = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$char";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // In production, log error instead of showing it
    error_log($e->getMessage());
    die("A database error occurred. Please try again later.");
}

/**
 * Helper function to sanitize output
 */
function s($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
?>