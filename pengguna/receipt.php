<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['level'] !== 'pengguna') {
    header("Location: ../login.php");
    exit;
}

include '../includes/db.php'; // Include koneksi database

$user_id = $_SESSION['user_id'];
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;

// Fetch booking details along with payment details
$stmt = $conn->prepare("
    SELECT bookings.*, rooms.room_number, users.name AS user_name, payments.payment_date, payments.amount_paid, payments.payment_method
    FROM bookings
    LEFT JOIN rooms ON bookings.room_id = rooms.room_id
    LEFT JOIN users ON bookings.user_id = users.user_id
    LEFT JOIN payments ON bookings.booking_id = payments.booking_id
    WHERE bookings.booking_id = ? AND bookings.user_id = ?
");
$stmt->execute([$booking_id, $user_id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    die("Booking not found or you're not authorized to view this.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Hotel UYU</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .logo {
            font-family: 'Arial Black', Arial, sans-serif;
            font-size: 4rem;
            text-align: center;
            color: #007BFF;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        .back-button {
            position: absolute;
            top: 50px;  /* Lowered to prevent overlap with navbar */
            left: 20px;
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            display: inline-block;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2.2rem;
            color: #007BFF;
        }
        .receipt-header {
            margin-bottom: 30px;
        }
        .receipt-details {
            margin-bottom: 20px;
        }
        .receipt-details p {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        .receipt-footer {
            text-align: center;
            margin-top: 30px;
        }
        .btn-print {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            text-decoration: none;
        }
        .btn-print:hover {
            background-color: #0056b3;
        }

        @media print {
            .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="logo">UYU</div>
    <a href="transaksi_pengguna.php" class="back-button btn-print">Back</a>
    <div class="container">
        <h1>Receipt for Booking ID: <?php echo $booking['booking_id']; ?></h1>
        
        <div class="receipt-header">
            <h2>Hotel UYU</h2>
            <p>Address: Jl. Hotel UYU No. 1, Kota XYZ, Indonesia</p>
        </div>

        <div class="receipt-details">
            <p><strong>User Name:</strong> <?php echo htmlspecialchars($booking['user_name']); ?></p>
            <p><strong>Room Number:</strong> <?php echo htmlspecialchars($booking['room_number']); ?></p>
            <p><strong>Check-In Date:</strong> <?php echo $booking['check_in_date']; ?></p>
            <p><strong>Check-Out Date:</strong> <?php echo $booking['check_out_date']; ?></p>
            <p><strong>Total Price:</strong> $ <?php echo number_format($booking['total_price'], 2, ',', '.'); ?></p>
        </div>

        <div class="receipt-details">
            <h3>Payment Details</h3>
            <p><strong>Payment Date:</strong> <?php echo $booking['payment_date']; ?></p>
            <p><strong>Amount Paid:</strong> $ <?php echo number_format($booking['amount_paid'], 2, ',', '.'); ?></p>
            <p><strong>Payment Method:</strong> <?php echo ucfirst($booking['payment_method']); ?></p>
        </div>

        <div class="receipt-footer">
            <p>Thank you for staying at Hotel UYU!</p>
            <a href="javascript:window.print()" class="btn-print">Print Receipt</a>
        </div>
    </div>
</body>
</html>
