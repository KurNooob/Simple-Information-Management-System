<?php
session_start();
if ($_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $room_id = $_POST['room_id'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $total_price = $_POST['total_price'];
    $booking_status = $_POST['booking_status'];

    $stmt = $conn->prepare("INSERT INTO bookings (user_id, room_id, check_in_date, check_out_date, total_price, booking_status) 
                            VALUES (:user_id, :room_id, :check_in_date, :check_out_date, :total_price, :booking_status)");
    $stmt->execute([
        'user_id' => $user_id,
        'room_id' => $room_id,
        'check_in_date' => $check_in_date,
        'check_out_date' => $check_out_date,
        'total_price' => $total_price,
        'booking_status' => $booking_status
    ]);

    header("Location: alter_data.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Booking</title>
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
        form {
            width: 50%;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        label {
            font-size: 16px;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }
        input[type="number"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        button:active {
            background-color: #004080;
        }
        .cancel-button {
            background-color: #dc3545;
            margin-left: 10px;
        }
        .cancel-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <h1>Add Booking</h1>
    <form method="post">
        <label>User ID:</label>
        <input type="number" name="user_id" required><br>
        <label>Room ID:</label>
        <input type="number" name="room_id" required><br>
        <label>Check-In Date:</label>
        <input type="date" name="check_in_date" required><br>
        <label>Check-Out Date:</label>
        <input type="date" name="check_out_date" required><br>
        <label>Total Price:</label>
        <input type="number" name="total_price" required><br>
        <label>Status:</label>
        <select name="booking_status">
            <option value="confirmed">Confirmed</option>
            <option value="pending">Pending</option>
            <option value="cancelled">Cancelled</option>
        </select><br>
        <button type="submit">Add Booking</button>
        <a href="alter_data.php" class="cancel-button"><button type="button" class="cancel-button">Cancel</button></a> <!-- Cancel button -->
    </form>
</body>
</html>
