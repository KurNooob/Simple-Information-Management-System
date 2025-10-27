<?php
session_start();
if ($_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';

$room_id = $_GET['room_id'];
$stmt = $conn->prepare("SELECT * FROM rooms WHERE room_id = :room_id");
$stmt->execute(['room_id' => $room_id]);
$room = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle room update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $price_per_night = $_POST['price_per_night'];
    $availability = $_POST['availability'];

    $stmt = $conn->prepare("UPDATE rooms SET room_number = :room_number, room_type = :room_type, 
                            price_per_night = :price_per_night, availability = :availability WHERE room_id = :room_id");
    $stmt->execute([
        'room_number' => $room_number,
        'room_type' => $room_type,
        'price_per_night' => $price_per_night,
        'availability' => $availability,
        'room_id' => $room_id
    ]);

    header("Location: rooms.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Room</title>
    <link rel="stylesheet" href="../css/style.css">
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

        /* Edit room form container */
        .edit-room-container {
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
    </style>
</head>
<body>
    <h1>Edit Room</h1>
    
    <!-- Back button to go back to room list -->
    <a href="rooms.php" class="back-button">Back</a>

    <div class="edit-room-container">
        <form method="post">
            <label>Room Number:</label>
            <input type="text" name="room_number" value="<?php echo $room['room_number']; ?>" class="form-input" required><br>
            <label>Room Type:</label>
            <input type="text" name="room_type" value="<?php echo $room['room_type']; ?>" class="form-input" required><br>
            <label>Price per Night:</label>
            <input type="number" name="price_per_night" value="<?php echo $room['price_per_night']; ?>" class="form-input" required><br>
            <label>Availability:</label>
            <select name="availability" class="form-input">
                <option value="YES" <?php echo $room['availability'] === 'YES' ? 'selected' : ''; ?>>YES</option>
                <option value="NO" <?php echo $room['availability'] === 'NO' ? 'selected' : ''; ?>>NO</option>
            </select><br>
            <button type="submit" class="form-button">Save Changes</button>
        </form>
    </div>
</body>
</html>
