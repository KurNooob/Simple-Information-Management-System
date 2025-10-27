<?php
session_start();
if ($_SESSION['level'] !== 'pengguna') {
    header("Location: /login.php");
    exit;
}
include '../includes/navbar_pengguna.php';  // Include the pengguna navbar
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorial - How to Book a Room</title>
    <link rel="stylesheet" href="../css/style2.css">  <!-- Assuming your CSS is here -->
    <style>
        h1 {
            text-align: center;
            margin-top: 30px;
            font-size: 2rem;
            color: #007BFF;
        }
        .tutorial-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-around;
            padding: 20px;
        }
        .tutorial-card {
            width: 30%; /* 3 cards per row */
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .tutorial-card:hover {
            transform: scale(1.05);  /* Hover effect */
        }
        .card-title {
            font-size: 1.5rem;
            color: #007BFF;
            margin-bottom: 10px;
        }
        .card-text {
            font-size: 1rem;
            color: #555;
        }
        .contact-info {
            font-size: 1rem;
            margin-top: 10px;
            color: #333;
        }
        @media (max-width: 768px) {
            .tutorial-card {
                width: 45%;  /* 2 cards per row */
            }
        }
        @media (max-width: 480px) {
            .tutorial-card {
                width: 100%;  /* 1 card per row */
            }
        }
    </style>
</head>
<body>
    <?php navbar_pengguna('how'); ?>  <!-- Call the pengguna navbar -->
    
    <h1>How to Book a Room</h1>
    <div class="tutorial-container">
        <div class="tutorial-card">
            <div class="card-title">Step 1: Browse Rooms</div>
            <div class="card-text">View available rooms. Greyed-out rooms are unavailable for booking.</div>
        </div>
        <div class="tutorial-card">
            <div class="card-title">Step 2: Select a Room</div>
            <div class="card-text">Choose a room based on availability, room type, and price.</div>
        </div>
        <div class="tutorial-card">
            <div class="card-title">Step 3: Select Dates</div>
            <div class="card-text">Choose your check-in and check-out dates. The total price will be calculated.</div>
        </div>
        <div class="tutorial-card">
            <div class="card-title">Step 4: Confirm Booking</div>
            <div class="card-text">Confirm your booking details. The room will be reserved for your selected dates.</div>
        </div>
        <div class="tutorial-card">
            <div class="card-title">Step 5: Payment</div>
            <div class="card-text">After booking, visit the transaction page to view and pay for your booking. You could also cancel bookings.</div>
        </div>
        <div class="tutorial-card">
            <div class="card-title">Contact Us</div>
            <div class="card-text">
                For any questions or assistance, please contact us at:
                <div class="contact-info">
                    Email: <a href="mailto:uyu@uyu.com">uyu@uyu.com</a><br>
                    Phone: +1-234-567-8901
                </div>
            </div>
        </div>
    </div>
</body>
</html>
