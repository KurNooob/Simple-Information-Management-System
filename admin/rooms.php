<?php
session_start();
if ($_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';
include '../includes/navbar_admin.php';

// Fetch all rooms
$stmt = $conn->query("SELECT * FROM rooms");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Rooms</title>
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
        td.actions-cell {
            text-align: center;
            width: 150px;
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
        .add-room-btn {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            display: block; /* Make the button a block element */
            margin: 20px auto; /* Center the button horizontally */
            width: fit-content; /* Ensure the button's width adjusts based on content */
        }
        .add-room-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <?php navbar_admin('rooms'); ?>
    <h1>Manage Rooms</h1>
    <a href="add_room.php" class="add-room-btn">Add Room</a>
    <table>
        <tr>
            <th>Room ID</th>
            <th>Room Number</th>
            <th>Room Type</th>
            <th>Price per Night</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($rooms as $room): ?>
        <tr>
            <td><?php echo $room['room_id']; ?></td>
            <td><?php echo $room['room_number']; ?></td>
            <td><?php echo $room['room_type']; ?></td>
            <td><?php echo $room['price_per_night']; ?></td>
            <td><?php echo $room['availability']; ?></td>
            <td class="actions-cell">
                <!-- Edit Button -->
                <a href="edit_room.php?room_id=<?php echo $room['room_id']; ?>" class="btn btn-edit">Edit</a>
                <!-- Delete Button -->
                <button onclick="confirmDelete(<?php echo $room['room_id']; ?>)" class="btn btn-delete">Delete</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <script>
        function confirmDelete(room_id) {
            if (confirm("Are you sure you want to delete this room?")) {
                window.location.href = "delete_room.php?room_id=" + room_id;
            }
        }
    </script>
</body>
</html>
