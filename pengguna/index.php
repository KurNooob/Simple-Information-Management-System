<?php
session_start();
if ($_SESSION['level'] !== 'pengguna') {
    header("Location: /login.php");
    exit;
}
include '../includes/navbar_pengguna.php';
include '../includes/db.php';

// Fetch room data
$rooms = $conn->query("SELECT room_id, room_number, room_type, price_per_night, availability FROM rooms")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Room Listings</title>
    <link rel="stylesheet" href="../css/style2.css">
    <style>
        h1 {
            text-align: center;
            margin-top: 30px;
            font-size: 2rem;
            color: #007BFF;
        }
        .room-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-around;
            padding: 20px;
        }
        .room-card {
            width: 30%; /* Smaller cards, 3 in a row */
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            overflow: hidden;
        }
        .room-card img {
            width: 80%;  /* Smaller image width */
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin: 0 auto 10px; /* Centered image with bottom margin */
            display: block;
        }
        .room-card:hover {
            transform: scale(1.05);
        }
        .room-card.unavailable {
            filter: grayscale(100%);
            opacity: 0.6;
            pointer-events: none;
        }
        .room-number {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0 5px;
        }
        .room-type {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }
        .room-details {
            font-size: 16px;
            color: #555;
        }
        .connect-button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
        }
        .connect-button.disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        /* Responsive layout adjustments */
        @media (max-width: 768px) {
            .room-card {
                width: 45%; /* 2 in a row on medium screens */
            }
        }
        @media (max-width: 480px) {
            .room-card {
                width: 100%; /* 1 in a row on small screens */
            }
        }
    </style>
</head>
<body>
    <?php navbar_pengguna('booking'); ?>
    <h1>Available Rooms at UYU</h1>
    <div class="room-container">
        <?php foreach ($rooms as $room): ?>
            <div class="room-card <?php echo $room['availability'] === 'NO' ? 'unavailable' : ''; ?>">
                <img src="../assets/default_hotel.jpeg" alt="Room Image">
                <div class="room-number">Room <?php echo htmlspecialchars($room['room_number']); ?></div>
                <div class="room-type"><?php echo htmlspecialchars($room['room_type']); ?></div>
                <div class="room-details">
                    <p>$<?php echo htmlspecialchars($room['price_per_night']); ?> per night</p>
                </div>
                <a href="book_room.php?room_id=<?php echo $room['room_id']; ?>" class="connect-button <?php echo $room['availability'] === 'NO' ? 'disabled' : ''; ?>">
                    Book Now
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
