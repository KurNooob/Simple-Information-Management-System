<?php
session_start();
if ($_SESSION['level'] !== 'manager') {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';
include '../includes/navbar_manager.php';  // Use navbar_manager for manager

// Fetch all bookings
$stmt = $conn->query("SELECT * FROM bookings");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Bookings</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 30px;
            font-size: 2rem;
            color: #007BFF;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 16px;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
            color: #333;
        }
        td {
            color: #555;
        }
        .add-booking-button {
            display: none;  /* Hide the add booking button */
        }
    </style>
</head>
<body>
    <?php navbar_manager('bookings'); ?>  <!-- Use navbar_manager here -->
    <h1>View Bookings</h1>
    <table>
        <tr>
            <th>Booking ID</th>
            <th>User ID</th>
            <th>Room ID</th>
            <th>Check-In</th>
            <th>Check-Out</th>
            <th>Total Price</th>
            <th>Status</th>
        </tr>
        <?php foreach ($bookings as $booking): ?>
        <tr>
            <td><?php echo $booking['booking_id']; ?></td>
            <td><?php echo $booking['user_id']; ?></td>
            <td><?php echo $booking['room_id']; ?></td>
            <td><?php echo $booking['check_in_date']; ?></td>
            <td><?php echo $booking['check_out_date']; ?></td>
            <td><?php echo $booking['total_price']; ?></td>
            <td><?php echo $booking['booking_status']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
