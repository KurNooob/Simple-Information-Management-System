<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->rowCount() > 0) {
        $error = "Email is already registered!";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert user into database
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, level) VALUES (:name, :email, :password, 'pengguna')");
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);

        header("Location: login.php?success=registered");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <div class="logo">UYU</div>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="register-container">
        <h1>Register</h1>
        <form method="post">
            <label>Name:</label>
            <input type="text" name="name" required>
            <br>
            <label>Email:</label>
            <input type="email" name="email" required>
            <br>
            <label>Password:</label>
            <input type="password" name="password" required>
            <br>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>

    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .logo {
            font-family: 'Arial Black', Arial, sans-serif;
            font-size: 4rem;
            text-align: center;
            color: #007BFF;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        /* Register Container */
        .register-container {
            max-width: 500px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #007BFF;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            max-width: 400px;  /* Set a max-width */
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;  /* Ensures padding doesn't affect the width */
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus {
            border-color: #007BFF;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            width: 100%;
            max-width: 400px;  /* Set max width for the button */
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        button[type="submit"]:active {
            background-color: #004080;
        }

        p {
            font-size: 14px;
        }

        a {
            color: #007BFF;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>
</body>
</html>
