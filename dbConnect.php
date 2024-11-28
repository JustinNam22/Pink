<?php 
$host = "localhost";
$dbname = 'hn';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo; // Ensure the PDO object is returned
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
