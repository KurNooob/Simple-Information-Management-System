<?php
session_start();
if ($_SESSION['level'] !== 'pengguna') {
    header("Location: ../login.php");
    exit;
}

include '../includes/db.php'; // Include your database connection
include '../includes/navbar_pengguna.php'; // Include the navbar for users

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userInput = trim($_POST['user_input']);
    $response = "";

    if (!empty($userInput)) {
        // Search the database for the user's question
        $stmt = $conn->prepare("SELECT answer FROM chatbot WHERE question = ?");
        $stmt->execute([$userInput]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $response = $result['answer'];
        } else {
            $response = "I'm sorry, I don't understand that. Can you ask something else?";
        }
    } else {
        $response = "Please enter a question.";
    }

    echo $response;
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chatbot</title>
    <link rel="stylesheet" href="../css/style2.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .chat-container {
            width: 100%;
            max-width: 500px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }
        h1 {
            text-align: center;
            color: #007BFF;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .chat-box {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
        }
        .chat-box .message {
            margin: 10px 0;
            padding: 10px;
            border-radius: 15px;
            max-width: 80%;
            word-wrap: break-word;
            display: inline-block;
            position: relative;
        }
        .chat-box .user {
            background-color: #007BFF;
            color: white;
            align-self: flex-end;
            border-radius: 15px 15px 0 15px;
        }
        .chat-box .bot {
            background-color: #e2e2e2;
            color: #333;
            align-self: flex-start;
            border-radius: 15px 15px 15px 0;
        }
        form {
            display: flex;
            gap: 10px;
        }
        input[type="text"] {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <?php navbar_pengguna('chatbot'); // Display the navbar with the chatbot menu active ?>
    <div class="chat-container">
        <h1>Chatbot</h1>
        <div class="chat-box" id="chatBox"></div>
        <form id="chatForm">
            <input type="text" id="userInput" placeholder="Type your question here..." required>
            <button type="submit">Send</button>
        </form>
    </div>

    <script>
        const chatBox = document.getElementById('chatBox');
        const chatForm = document.getElementById('chatForm');
        const userInput = document.getElementById('userInput');

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const userMessage = userInput.value;
            appendMessage(userMessage, 'user');  // Send user message
            userInput.value = '';

            try {
                const response = await fetch('chatbot.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `user_input=${encodeURIComponent(userMessage)}`
                });
                const botMessage = await response.text();
                appendMessage(botMessage, 'bot');  // Send bot response
            } catch (error) {
                appendMessage("There was an error. Please try again.", 'bot');
            }
        });

        function appendMessage(message, sender) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${sender}`; // Add sender class (user or bot)
            messageDiv.textContent = message;
            chatBox.appendChild(messageDiv);
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    </script>
</body>
</html>
