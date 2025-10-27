<?php
session_start();
if ($_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';

$booking_id = $_GET['booking_id'];
$stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = :booking_id");
$stmt->execute(['booking_id' => $booking_id]);

header("Location: alter_data.php");
exit;
?>