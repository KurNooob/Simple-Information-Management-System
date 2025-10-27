<?php
session_start();
if ($_SESSION['level'] !== 'pengguna') {
    header("Location: /login.php");
    exit;
}
include '../includes/navbar_pengguna.php';
include '../includes/db.php';

// Get room_id from URL
$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;

// Fetch room details from the database
$roomQuery = $conn->prepare("SELECT room_number, room_type, price_per_night FROM rooms WHERE room_id = ?");
$roomQuery->execute([$room_id]);
$room = $roomQuery->fetch(PDO::FETCH_ASSOC);

if (!$room) {
    die('Room not found.');
}

$bookingConfirmed = false; // Flag to track booking status

// Handle form submission for booking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];

    // Calculate the number of nights
    $check_in = new DateTime($check_in_date);
    $check_out = new DateTime($check_out_date);
    $interval = $check_in->diff($check_out);
    $nights = $interval->days;

    // Calculate the total price
    $total_price = $room['price_per_night'] * $nights;

    // Insert booking into the database (without booking status, it will default to Pending)
    $user_id = $_SESSION['user_id'];  // Assuming the user ID is stored in the session
    $bookingQuery = $conn->prepare("INSERT INTO bookings (user_id, room_id, check_in_date, check_out_date, total_price) VALUES (?, ?, ?, ?, ?)");
    $bookingQuery->execute([$user_id, $room_id, $check_in_date, $check_out_date, $total_price]);

    // Update room availability to 'NO' after successful booking
    $updateRoomQuery = $conn->prepare("UPDATE rooms SET availability = 'NO' WHERE room_id = ?");
    $updateRoomQuery->execute([$room_id]);

    $bookingConfirmed = true; // Set flag to true after booking
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room</title>
    <link rel="stylesheet" href="../css/style2.css">
    <style>
        /* Back button styles */
        h2 {
            text-align: center;
            margin-top: 30px;
            font-size: 2rem;
            color: #007BFF;
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

        /* Booking form container */
        .booking-container {
            max-width: 500px;
            margin: 80px auto 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        /* Form input styles */
        .form-input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form-input:focus {
            border-color: #007BFF;
        }

        /* Submit button */
        .form-button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-button:hover {
            background-color: #0056b3;
        }

        /* Price display */
        .price-display {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            text-align: center;
        }

        /* Confirmation message */
        .confirmation-message {
            text-align: center;
            font-size: 1.2rem;
            color: #28a745;
            margin-top: 20px;
        }

        /* Continue to payment button */
        .continue-payment-btn {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            font-weight: bold;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        .continue-payment-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <?php navbar_pengguna('booking'); ?>

    <!-- Back button to go back to index -->
    <a href="index.php" class="back-button">Back</a>

    <div class="booking-container">
        <?php if ($bookingConfirmed): ?>
            <!-- Show booking confirmation and payment button after successful booking -->
            <div class="confirmation-message">
                <p>You have successfully booked this room.</p>
                <a href="transaksi_pengguna.php" class="continue-payment-btn">Continue to Payment</a>
            </div>
        <?php else: ?>
            <!-- Booking form if not confirmed -->
            <h2>Book Room: Room <?php echo $room['room_number']; ?></h2>
            <form method="POST">
                <div class="date-inputs">
                    <div>
                        <label for="check_in_date">Check-in Date:</label>
                        <input type="date" id="check_in_date" name="check_in_date" class="form-input" required>
                    </div>
                    <div>
                        <label for="check_out_date">Check-out Date:</label>
                        <input type="date" id="check_out_date" name="check_out_date" class="form-input" required>
                    </div>
                </div>

                <div class="price-display" id="price-display">Total Price: $0.00</div>

                <button type="submit" class="form-button">Confirm Booking</button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        // Get the form elements
        const checkInDateInput = document.getElementById('check_in_date');
        const checkOutDateInput = document.getElementById('check_out_date');
        const priceDisplay = document.getElementById('price-display');

        const pricePerNight = <?php echo $room['price_per_night']; ?>;

        // Function to update the price display based on selected dates
        function updatePrice() {
            const checkInDate = new Date(checkInDateInput.value);
            const checkOutDate = new Date(checkOutDateInput.value);

            // If both dates are selected
            if (checkInDate && checkOutDate && checkInDate < checkOutDate) {
                const timeDifference = checkOutDate - checkInDate;
                const days = timeDifference / (1000 * 3600 * 24); // Convert milliseconds to days
                const totalPrice = days * pricePerNight;

                priceDisplay.textContent = 'Total Price: $' + totalPrice.toFixed(2);
            } else {
                priceDisplay.textContent = 'Total Price: $0.00';
            }
        }

        // Add event listeners to update price on date change
        checkInDateInput.addEventListener('change', updatePrice);
        checkOutDateInput.addEventListener('change', updatePrice);
    </script>
</body>
</html>
