<?php
session_start();
if ($_SESSION['level'] !== 'admin') {
    header("Location: /login.php");
    exit;
}
include '../includes/db.php';

// Fetch the Q&A to edit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $qa = $conn->prepare("SELECT * FROM chatbot WHERE id = :id");
    $qa->execute(['id' => $id]);
    $qaData = $qa->fetch(PDO::FETCH_ASSOC);
}

// Handle form submission to update Q&A
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    if (!empty($question) && !empty($answer)) {
        $stmt = $conn->prepare("UPDATE chatbot SET question = :question, answer = :answer WHERE id = :id");
        $stmt->execute(['question' => $question, 'answer' => $answer, 'id' => $id]);
        header("Location: chatbot_view.php"); // Redirect to main page
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Q&A</title>
    <link rel="stylesheet" href="../css/style2.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #007BFF;
            margin-bottom: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        form input, form textarea {
            width: 100%;
            padding: 10px;
            margin: 15px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        form button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        form button:hover {
            background-color: #0056b3;
        }

        form textarea {
            resize: vertical;
        }

        form input:focus, form textarea:focus {
            outline: none;
            border-color: #007BFF;
        }

        @media (max-width: 768px) {
            form {
                padding: 20px;
            }
            form button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <h1>Edit Question & Answer</h1>
    <form method="POST" action="">
        <input type="text" name="question" value="<?php echo htmlspecialchars($qaData['question']); ?>" required>
        <textarea name="answer" rows="3" required><?php echo htmlspecialchars($qaData['answer']); ?></textarea>
        <button type="submit" name="update">Update Q&A</button>
    </form>
</body>
</html>
