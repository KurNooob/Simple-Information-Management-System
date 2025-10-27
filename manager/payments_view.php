<?php
session_start();
if ($_SESSION['level'] !== 'manager') {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';
include '../includes/navbar_manager.php'; // Use the manager navbar

// Fetch payment data
$stmt = $conn->query("
    SELECT p.payment_id, p.booking_id, p.payment_date, p.amount_paid, p.payment_method, 
           b.check_in_date, b.check_out_date
    FROM payments p
    JOIN bookings b ON p.booking_id = b.booking_id
");
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Payments</title>
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
    </style>
</head>
<body>
    <?php navbar_manager('payments'); ?> <!-- Use the manager navbar -->
    <h1>View Payments</h1>
    <table>
        <tr>
            <th>Payment ID</th>
            <th>Booking ID</th>
            <th>Payment Date</th>
            <th>Amount Paid</th>
            <th>Payment Method</th>
            <th>Check-In Date</th>
            <th>Check-Out Date</th>
        </tr>
        <?php foreach ($payments as $payment): ?>
        <tr>
            <td><?php echo $payment['payment_id']; ?></td>
            <td><?php echo $payment['booking_id']; ?></td>
            <td><?php echo $payment['payment_date']; ?></td>
            <td>$<?php echo number_format($payment['amount_paid'], 2); ?></td>
            <td><?php echo ucfirst($payment['payment_method']); ?></td>
            <td><?php echo $payment['check_in_date']; ?></td>
            <td><?php echo $payment['check_out_date']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
