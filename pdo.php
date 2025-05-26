<?php
// PDO.php
$host = 'yourhosyname';//usually lovalhost in cpanel
$db   = 'yourdatabasenam';
$user = 'yourusername';
$pass = 'yourpassword';
$charset = 'utf8mb4';//set to this charset to allow emojis (mostly for usernames, mocies description and the rest)

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . htmlspecialchars($e->getMessage()));
}