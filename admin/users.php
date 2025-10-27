<?php
session_start();
if ($_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';
include '../includes/navbar_admin.php';

// Fetch all users
$stmt = $conn->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
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
    </style>
</head>
<body>
    <?php navbar_admin('users'); ?>
    <h1>Manage Users</h1>
    <table>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Level</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['user_id']); ?></td>
            <td><?php echo htmlspecialchars($user['name']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><?php echo htmlspecialchars($user['level']); ?></td>
            <td class="actions-cell">
                <!-- Edit Button -->
                <a href="edit_user.php?user_id=<?php echo htmlspecialchars($user['user_id']); ?>" class="btn btn-edit">Edit</a>
                <!-- Delete Button -->
                <button onclick="confirmDelete(<?php echo $user['user_id']; ?>)" class="btn btn-delete">Delete</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <script>
        function confirmDelete(user_id) {
            if (confirm("Are you sure you want to delete this user?")) {
                window.location.href = "delete_user.php?user_id=" + user_id;
            }
        }
    </script>
</body>
</html>
