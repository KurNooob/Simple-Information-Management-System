<?php
session_start();
if ($_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';
include '../includes/navbar_admin.php';

// Fetch all bookings
$stmt = $conn->query("SELECT * FROM bookings");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Alter Data</title>
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
        .btn {
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .btn-edit {
            background-color: #007BFF;
            color: white;
        }
        .btn-edit:hover {
            background-color: #0056b3;
        }
        .btn-edit:active {
            background-color: #004080;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        .btn-delete:active {
            background-color: #bd2130;
        }
        .add-booking-button {
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            font-size: 16px;
            padding: 10px 20px;
            transition: background-color 0.3s;
            margin-top: 20px;
            display: block;
            width: 200px;
            margin: 20px auto;
        }
        .add-booking-button:hover {
            background-color: #218838;
        }
        .add-booking-button:active {
            background-color: #1e7e34;
        }

        /* Center buttons in the Actions column */
        .actions-column {
            text-align: center;
        }
    </style>
</head>
<body>
    <?php navbar_admin('alter'); ?>
    <h1>Manage Bookings</h1>
    <button onclick="window.location.href='add_booking.php'" class="add-booking-button">Add Booking</button>
    <table>
        <tr>
            <th>Booking ID</th>
            <th>User ID</th>
            <th>Room ID</th>
            <th>Check-In</th>
            <th>Check-Out</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Actions</th>
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
            <td class="actions-column">
                <!-- Edit Button -->
                <a href="edit_booking.php?booking_id=<?php echo $booking['booking_id']; ?>" class="btn btn-edit">Edit</a>
                <!-- Delete Button -->
                <button onclick="confirmDelete(<?php echo $booking['booking_id']; ?>)" class="btn btn-delete">Delete</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <script>
        // Function to show confirmation popup for delete
        function confirmDelete(booking_id) {
            if (confirm("Are you sure you want to delete this booking?")) {
                window.location.href = "delete_booking.php?booking_id=" + booking_id;
            }
        }
    </script>
</body>
</html>
