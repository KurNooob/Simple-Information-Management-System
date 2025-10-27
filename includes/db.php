<?php
// Database connection
$host = 'localhost';
$db = 'hotel';
$user = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=localhost;dbname=hotel", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
