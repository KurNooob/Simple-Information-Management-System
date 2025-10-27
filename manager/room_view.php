<?php
session_start();
if ($_SESSION['level'] !== 'manager') {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';
include '../includes/navbar_manager.php';  // Use navbar_manager for the manager

// Fetch all rooms
$stmt = $conn->query("SELECT * FROM rooms");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Rooms</title>
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
        td.actions-cell {
            text-align: center;
            width: 150px;
        }
        .add-room-btn {
            display: none;  /* Hide the add room button */
        }
    </style>
</head>
<body>
    <?php navbar_manager('rooms'); ?>  <!-- Use navbar_manager here -->
    <h1>View Rooms</h1>
    <table>
        <tr>
            <th>Room ID</th>
            <th>Room Number</th>
            <th>Room Type</th>
            <th>Price per Night</th>
            <th>Status</th>
        </tr>
        <?php foreach ($rooms as $room): ?>
        <tr>
            <td><?php echo $room['room_id']; ?></td>
            <td><?php echo $room['room_number']; ?></td>
            <td><?php echo $room['room_type']; ?></td>
            <td><?php echo $room['price_per_night']; ?></td>
            <td><?php echo $room['availability']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
