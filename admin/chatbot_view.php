<?php
session_start();
if ($_SESSION['level'] !== 'admin') {
    header("Location: /login.php");
    exit;
}
include '../includes/db.php';
include '../includes/navbar_admin.php';

// Handle form submission for adding a question and answer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $question = $_POST['question'];
    $answer = $_POST['answer'];

    if (!empty($question) && !empty($answer)) {
        $stmt = $conn->prepare("INSERT INTO chatbot (question, answer) VALUES (:question, :answer)");
        $stmt->execute(['question' => $question, 'answer' => $answer]);
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    }
}

// Handle deletion of a question and answer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $deleteId = $_POST['delete_id'];
    $stmt = $conn->prepare("DELETE FROM chatbot WHERE id = :id");
    $stmt->execute(['id' => $deleteId]);
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

// Fetch all questions and answers
$chatbotData = $conn->query("SELECT * FROM chatbot ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <?php navbar_admin('chatbot'); ?>
    <title>Manage Chatbot Q&A</title>
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
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        .add-form {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
        .add-form h2 {
            margin-top: 0;
        }
        .add-form input, .add-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .add-form button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        .add-form button:hover {
            background-color: #0056b3;
        }
        .qa-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .qa-table th, .qa-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        .qa-table th {
            background-color: #f0f0f0;
        }
        .action-buttons form {
            display: inline-block;
        }
        .action-buttons button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 5px 10px;
            margin: 0 5px;
            border-radius: 4px;
            cursor: pointer;
        }
        .action-buttons button.delete {
            background-color: #FF4D4D;
        }
        .action-buttons button:hover {
            opacity: 0.8;
        }
    </style>
    <script>
        // JavaScript to show confirmation before deletion
        function confirmDelete(event) {
            if (!confirm("Are you sure you want to delete this chat?")) {
                event.preventDefault(); // Prevent form submission if not confirmed
            }
        }
    </script>
</head>
<body>
    <h1>Manage Chatbot Q&A</h1>
    <div class="container">
        <!-- Form to Add Q&A -->
        <div class="add-form">
            <h2>Add Question & Answer</h2>
            <form method="POST" action="">
                <input type="text" name="question" placeholder="Enter question" required>
                <textarea name="answer" rows="3" placeholder="Enter answer" required></textarea>
                <button type="submit" name="add">Add Q&A</button>
            </form>
        </div>

        <!-- Display Q&A -->
        <table class="qa-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($chatbotData)): ?>
                    <?php foreach ($chatbotData as $qa): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($qa['id']); ?></td>
                            <td><?php echo htmlspecialchars($qa['question']); ?></td>
                            <td><?php echo htmlspecialchars($qa['answer']); ?></td>
                            <td class="action-buttons">
                                <!-- Edit Button -->
                                <form action="edit_chatbot.php" method="GET">
                                    <input type="hidden" name="id" value="<?php echo $qa['id']; ?>">
                                    <button type="submit">Edit</button>
                                </form>
                                <!-- Delete Button -->
                                <form method="POST" action="" onsubmit="confirmDelete(event)">
                                    <input type="hidden" name="delete_id" value="<?php echo $qa['id']; ?>">
                                    <button type="submit" name="delete" class="delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">No Q&A found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
