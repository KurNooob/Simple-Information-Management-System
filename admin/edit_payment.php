<?php
session_start();
if ($_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

include '../includes/db.php';

if (isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];
    $stmt = $conn->prepare("SELECT * FROM payments WHERE payment_id = :payment_id");
    $stmt->execute(['payment_id' => $payment_id]);
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle form submission for updating payment details
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $amount_paid = $_POST['amount_paid'];
    $payment_method = $_POST['payment_method'];
    $payment_date = $_POST['payment_date'];

    if (!empty($amount_paid) && !empty($payment_method) && !empty($payment_date)) {
        $stmt = $conn->prepare("UPDATE payments SET amount_paid = :amount_paid, payment_method = :payment_method, payment_date = :payment_date WHERE payment_id = :payment_id");
        $stmt->execute([
            'amount_paid' => $amount_paid,
            'payment_method' => $payment_method,
            'payment_date' => $payment_date,
            'payment_id' => $payment_id
        ]);
        header("Location: payments.php"); // Redirect to the payments page after update
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Payment</title>
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
            margin-bottom: 10px;
            display: block;
        }

        input, select, button {
            width: 100%;
            padding: 12px;
            margin: 10px 0 20px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        input[type="number"], input[type="date"], select {
            width: calc(100% - 24px); /* Account for padding */
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 14px;
            font-size: 18px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <h1>Edit Payment</h1>
    <form method="POST" action="">
        <label for="amount_paid">Amount Paid:</label>
        <input type="number" step="0.01" name="amount_paid" value="<?php echo $payment['amount_paid']; ?>" required>
        
        <label for="payment_method">Payment Method:</label>
        <select name="payment_method" required>
            <option value="credit_card" <?php echo $payment['payment_method'] === 'Credit_card' ? 'selected' : ''; ?>>Credit Card</option>
            <option value="paypal" <?php echo $payment['payment_method'] === 'Cash' ? 'selected' : ''; ?>>Cash</option>
            <option value="bank_transfer" <?php echo $payment['payment_method'] === 'Bank_transfer' ? 'selected' : ''; ?>>Bank Transfer</option>
        </select>

        <label for="payment_date">Payment Date:</label>
        <input type="date" name="payment_date" value="<?php echo $payment['payment_date']; ?>" required>

        <button type="submit" name="update">Update Payment</button>
    </form>
</body>
</html>
