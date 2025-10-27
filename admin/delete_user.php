<?php
session_start();
if ($_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';

// Get the user_id from the URL
if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    die("Invalid User ID.");
}

$user_id = $_GET['user_id'];

// Delete the user
$stmt = $conn->prepare("DELETE FROM users WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);

// Redirect back to the manage users page
header("Location: chatbot_view.php");
exit;
?>
