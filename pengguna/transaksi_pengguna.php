<?php
session_start();
if ($_SESSION['level'] !== 'pengguna') {
    header("Location: ../login.php");
    exit;
}
include '../includes/navbar_pengguna.php';
include '../includes/db.php';

$user_id = $_SESSION['user_id'];

// Enable PDO error reporting
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch user's name from the users table
$userQuery = $conn->prepare("SELECT name FROM users WHERE user_id = ?");
$userQuery->execute([$user_id]);
$user = $userQuery->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

$stmt = $conn->prepare("
    SELECT 
        bookings.booking_id AS booking_id,
        bookings.check_in_date,
        bookings.check_out_date,
        bookings.total_price,
        bookings.booking_status,
        payments.amount_paid,
        rooms.room_number
    FROM bookings
    LEFT JOIN payments ON bookings.booking_id = payments.booking_id
    LEFT JOIN rooms ON bookings.room_id = rooms.room_id
    WHERE bookings.user_id = :user_id
");
$stmt->execute(['user_id' => $user_id]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Pengguna</title>
    <link rel="stylesheet" href="../css/style2.css">
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
        td.payment-cell {
            text-align: center;
            width: 150px;
        }
        .button-container {
            display: flex;
            justify-content: space-around;
            gap: 10px;
        }
        .btn {
            padding: 8px 16px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            display: inline-block;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .btn-edit {
            background-color: #007BFF;
            color: white;
            transition: background-color 0.3s;
        }
        .btn-delete {
            background-color: #DC3545;
            color: white;
            transition: background-color 0.3s;
            border: none;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .btn-edit:hover {
            background-color: #0056b3;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        .table-container {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <?php navbar_pengguna('transaksi'); ?>
    <div class="table-container">
        <h1>Transaksi <?php echo htmlspecialchars($user['name']); ?></h1>  <!-- Displaying user's name -->
        <table>
            <tr>
                <th>Booking ID</th>
                <th>Room Number</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Pembayaran</th>
                <th>Receipt</th>
            </tr>
            <?php foreach ($data as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['booking_id']); ?></td>
                <td><?php echo htmlspecialchars($row['room_number']); ?></td>
                <td><?php echo htmlspecialchars($row['check_in_date']); ?></td>
                <td><?php echo htmlspecialchars($row['check_out_date']); ?></td>
                <td>$<?php echo htmlspecialchars($row['total_price']); ?></td>
                <td><?php echo htmlspecialchars($row['booking_status']); ?></td>
                <td class="payment-cell">
                    <div class="button-container">
                        <?php if ($row['booking_status'] === 'Cancelled'): ?>
                            <span>Canceled</span>
                        <?php elseif (empty($row['amount_paid'])): ?>
                            <a href="pembayaran.php?booking_id=<?php echo htmlspecialchars($row['booking_id']); ?>" class="btn btn-edit">Bayar</a>
                            <button class="btn btn-delete" onclick="cancelBooking(<?php echo htmlspecialchars($row['booking_id']); ?>)">Cancel</button>
                        <?php else: ?>
                            <span>$<?php echo htmlspecialchars($row['amount_paid']); ?></span>
                        <?php endif; ?>
                    </div>
                </td>
                <td>
                    <?php if (!empty($row['amount_paid'])): ?>
                        <a href="receipt.php?booking_id=<?php echo htmlspecialchars($row['booking_id']); ?>" class="btn btn-edit">Print Receipt</a>
                    <?php else: ?>
                        <span>No Payment</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <script>
        // Function to cancel booking
        function cancelBooking(bookingId) {
            if (confirm("Are you sure you want to cancel this booking?")) {
                fetch("cancel_booking.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ booking_id: bookingId }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Booking canceled successfully!");
                        location.reload(); // Reload the page to update the table
                    } else {
                        alert("Failed to cancel the booking. Please try again.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred while canceling the booking.");
                });
            }
        }

        // Function to handle payment (dummy implementation)
        function payBooking(bookingId) {
            alert("Redirecting to payment for Booking ID: " + bookingId);
            // Implement actual payment redirection logic here
        }
    </script>
</body>
</html>
