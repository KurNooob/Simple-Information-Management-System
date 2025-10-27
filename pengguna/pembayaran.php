<?php
session_start();
if ($_SESSION['level'] !== 'pengguna') {
    header("Location: ../login.php");
    exit;
}
include '../includes/navbar_pengguna.php';
include '../includes/db.php';

// Get the booking_id from the URL
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;
$user_id = $_SESSION['user_id'];  // Get the user_id from the session

// Fetch booking details from the database based on booking_id, including room_number
$stmt = $conn->prepare("
    SELECT bookings.*, rooms.room_number 
    FROM bookings
    LEFT JOIN rooms ON bookings.room_id = rooms.room_id
    WHERE bookings.booking_id = ? AND bookings.user_id = ?
");
$stmt->execute([$booking_id, $user_id]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    die("Booking not found or you're not authorized to pay for this booking.");
}

// Track payment status
$paymentSuccessful = false;

// Handle the payment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'];
    $total_price = $booking['total_price'];
    $payment_date = date('Y-m-d');

    // Insert the payment into the payments table
    $stmt = $conn->prepare("INSERT INTO payments (booking_id, payment_date, amount_paid, payment_method) VALUES (?, ?, ?, ?)");
    $stmt->execute([$booking_id, $payment_date, $total_price, $payment_method]);

    // Update booking status to 'Confirmed'
    $stmt = $conn->prepare("UPDATE bookings SET booking_status = 'Confirmed' WHERE booking_id = ?");
    $stmt->execute([$booking_id]);

    $paymentSuccessful = true;  // Set to true after payment
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .payment-container {
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .payment-button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            display: block;
            margin: 10px 0;
        }
        .payment-button:hover {
            background-color: #0056b3;
        }
        .payment-details {
            margin-bottom: 20px;
        }
        .payment-details p {
            font-size: 16px;
        }
        .confirmation-message {
            text-align: center;
            font-size: 1.2rem;
            color: #28a745;
            margin-top: 20px;
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
    </style>
</head>
<body>
    <?php navbar_pengguna('pembayaran'); ?>
    <a href="transaksi_pengguna.php" class="back-button">Back</a>

    <h1>Pembayaran untuk Booking ID: <?php echo $booking['booking_id']; ?></h1>
    
    <div class="payment-container">
        <?php if ($paymentSuccessful): ?>
            <!-- Show confirmation message and button after payment -->
            <div class="confirmation-message">
                <p>Transaction Complete! Your booking is now confirmed.</p>
                <a href="transaksi_pengguna.php" class="payment-button">Go to Transactions</a>
            </div>
        <?php else: ?>
            <!-- Show booking details and payment form if not yet paid -->
            <div class="payment-details">
                <p><strong>Room Number:</strong> <?php echo htmlspecialchars($booking['room_number']); ?></p>
                <p><strong>Check-In:</strong> <?php echo $booking['check_in_date']; ?></p>
                <p><strong>Check-Out:</strong> <?php echo $booking['check_out_date']; ?></p>
                <p><strong>Total Price:</strong> $<?php echo $booking['total_price']; ?></p>
                <p><strong>Status:</strong> <?php echo $booking['booking_status']; ?></p>
            </div>

            <!-- Payment form -->
            <form method="POST">
                <label for="payment_method">Pilih Metode Pembayaran:</label>
                <select id="payment_method" name="payment_method" required class="form-input">
                    <option value="cash">Cash</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
                <button type="submit" class="payment-button">Bayar Sekarang</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
