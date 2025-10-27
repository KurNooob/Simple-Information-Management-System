<?php
session_start();
if ($_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';
include '../includes/navbar_admin.php';

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
    <title>Manage Payments</title>
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
        .actions-cell {
            text-align: center;
            width: 150px;
        }
        /* Style for the Edit button */
        .edit-button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .edit-button:hover {
            background-color: #0056b3;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <?php navbar_admin('payments'); ?>
    <h1>Manage Payments</h1>
    <table>
        <tr>
            <th>Payment ID</th>
            <th>Booking ID</th>
            <th>Payment Date</th>
            <th>Amount Paid</th>
            <th>Payment Method</th>
            <th>Check-In Date</th>
            <th>Check-Out Date</th>
            <th>Actions</th>
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
            <td class="actions-cell">
            <!-- Edit Button -->
            <form action="edit_payment.php" method="GET">
                <input type="hidden" name="payment_id" value="<?php echo $payment['payment_id']; ?>">
                <button type="submit" class="edit-button">Edit</button>
            </form>
        </td>
        <?php endforeach; ?>
    </table>
</body>
</html>
