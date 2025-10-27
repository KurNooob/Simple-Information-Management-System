<?php
session_start();
if ($_SESSION['level'] !== 'admin') {
    header("Location: /login.php");
    exit;
}
include '../includes/db.php';
include '../includes/navbar_admin.php';

// Handle deletion of a question and answer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $deleteId = $_POST['delete_id'];

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM chatbot WHERE id = :id");
    $stmt->execute(['id' => $deleteId]);

    // Redirect back to the page to reflect changes
    header("Location: /admin_chatbot.php");
    exit;
}

// Fetch all questions and answers for display
$chatbotData = $conn->query("SELECT * FROM chatbot ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
