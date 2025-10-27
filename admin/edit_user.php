<?php
session_start();
if ($_SESSION['level'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';
include '../includes/navbar_admin.php';

// Get the user_id from the URL
if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    die("Invalid User ID.");
}

$user_id = $_GET['user_id'];

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $level = $_POST['level'];

    // Update user in the database
    $updateStmt = $conn->prepare("
        UPDATE users SET name = :name, email = :email, level = :level WHERE user_id = :user_id
    ");
    $updateStmt->execute([
        'name' => $name,
        'email' => $email,
        'level' => $level,
        'user_id' => $user_id,
    ]);

    // Redirect to the manage users page
    header("Location: users.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .form-container {
            width: 60%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #007BFF;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 8px;
            font-weight: bold;
        }
        input, select {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #007BFF;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php navbar_admin('users'); ?>
    <div class="form-container">
        <h1>Edit User</h1>
        <form method="POST">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="level">Level</label>
            <select id="level" name="level" required>
                <option value="pengguna" <?php echo $user['level'] === 'pengguna' ? 'selected' : ''; ?>>Pengguna</option>
                <option value="admin" <?php echo $user['level'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="manager" <?php echo $user['level'] === 'manager' ? 'selected' : ''; ?>>Manager</option>
            </select>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</body>
</html>
