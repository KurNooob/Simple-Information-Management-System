<?php
session_start();
if ($_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';

$room_id = $_GET['room_id'];

// Delete room from the database
$stmt = $conn->prepare("DELETE FROM rooms WHERE room_id = :room_id");
$stmt->execute(['room_id' => $room_id]);

header("Location: alter_rooms.php");
exit;
?>
