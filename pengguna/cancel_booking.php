<?php
session_start();
if ($_SESSION['level'] !== 'pengguna') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

include '../includes/db.php';

// Retrieve booking_id from the request
$data = json_decode(file_get_contents("php://input"), true);
$booking_id = $data['booking_id'] ?? null;

if (!$booking_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid booking ID']);
    exit;
}

try {
    // Enable PDO error reporting
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Start a transaction
    $conn->beginTransaction();

    // Update the booking status to 'Canceled'
    $stmt = $conn->prepare("
        UPDATE bookings 
        SET booking_status = 'Cancelled' 
        WHERE booking_id = :booking_id
    ");
    $stmt->execute(['booking_id' => $booking_id]);

    // Set amount_paid to 0 in the payments table
    $paymentStmt = $conn->prepare("
        UPDATE payments 
        SET amount_paid = 0 
        WHERE booking_id = :booking_id
    ");
    $paymentStmt->execute(['booking_id' => $booking_id]);

    // Retrieve room_id from the booking
    $roomStmt = $conn->prepare("
        SELECT room_id 
        FROM bookings 
        WHERE booking_id = :booking_id
    ");
    $roomStmt->execute(['booking_id' => $booking_id]);
    $room = $roomStmt->fetch(PDO::FETCH_ASSOC);

    if ($room) {
        // Update the room's availability to 'YES'
        $roomUpdateStmt = $conn->prepare("
            UPDATE rooms 
            SET availability = 'YES' 
            WHERE room_id = :room_id
        ");
        $roomUpdateStmt->execute(['room_id' => $room['room_id']]);
    }

    // Commit the transaction
    $conn->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Roll back the transaction on error
    $conn->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
