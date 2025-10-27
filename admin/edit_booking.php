<?php
session_start();
if ($_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';

$booking_id = $_GET['booking_id'];
$stmt = $conn->prepare("SELECT * FROM bookings WHERE booking_id = :booking_id");
$stmt->execute(['booking_id' => $booking_id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $room_id = $_POST['room_id'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $total_price = $_POST['total_price'];
    $booking_status = $_POST['booking_status'];

    $stmt = $conn->prepare("UPDATE bookings SET user_id = :user_id, room_id = :room_id, check_in_date = :check_in_date, 
                            check_out_date = :check_out_date, total_price = :total_price, booking_status = :booking_status 
                            WHERE booking_id = :booking_id");
    $stmt->execute([
        'user_id' => $user_id,
        'room_id' => $room_id,
        'check_in_date' => $check_in_date,
        'check_out_date' => $check_out_date,
        'total_price' => $total_price,
        'booking_status' => $booking_status,
        'booking_id' => $booking_id
    ]);

    header("Location: alter_data.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Booking</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Back button styles */
        .back-button {
            position: absolute;
            top: 50px;  /* Adjusted position */
            left: 20px;
            background-color: #007BFF; /* Blue background */
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        .back-button:active {
            background-color: #004085; /* Even darker blue when clicked */
        }

        /* Edit Booking form styles */
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
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        button:active {
            background-color: #004080;
        }

        select {
            font-size: 16px;
        }
    </style>
</head>
<body>
    <!-- Back button to go back to booking list -->
    <a href="alter_data.php" class="back-button">Back</a>

    <h1>Edit Booking</h1>
    <form method="post">
        <label>User ID:</label>
        <input type="number" name="user_id" value="<?php echo $booking['user_id']; ?>" required><br>
        <label>Room ID:</label>
        <input type="number" name="room_id" value="<?php echo $booking['room_id']; ?>" required><br>
        <label>Check-In Date:</label>
        <input type="date" name="check_in_date" value="<?php echo $booking['check_in_date']; ?>" required><br>
        <label>Check-Out Date:</label>
        <input type="date" name="check_out_date" value="<?php echo $booking['check_out_date']; ?>" required><br>
        <label>Total Price:</label>
        <input type="number" name="total_price" value="<?php echo $booking['total_price']; ?>" required><br>
        <label>Status:</label>
        <select name="booking_status">
            <option value="confirmed" <?php echo $booking['booking_status'] === 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
            <option value="pending" <?php echo $booking['booking_status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="cancelled" <?php echo $booking['booking_status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
        </select><br>
        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
