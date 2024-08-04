<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #555;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            color: #333;
        }
        .form-group input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 18px;
            margin-top: 10px;
        }
        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 20px;
            font-weight: bold;
            color: red;
        }
        .toggle-form {
            margin-top: 10px;
            color: #007bff;
            cursor: pointer;
        }
    </style>
    <script>
        function toggleForm() {
            var formType = document.getElementById("form-type");
            var submitButton = document.getElementById("submit-button");
            var toggleText = document.getElementById("toggle-text");
            var title = document.getElementById("form-title");

            if (formType.value === "login") {
                formType.value = "signup";
                submitButton.value = "Sign Up";
                toggleText.innerText = "Already have an account? Login here.";
                title.innerText = "Sign Up";
            } else {
                formType.value = "login";
                submitButton.value = "Login";
                toggleText.innerText = "Don't have an account? Sign up here.";
                title.innerText = "Login";
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1 id="form-title">Login</h1>
        <form method="POST" action="process.php">
            <input type="hidden" id="form-type" name="form-type" value="login">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <input type="submit" id="submit-button" value="Login">
            </div>
        </form>
        <div class="message">
            <?php
            if (isset($_GET['message'])) {
                echo htmlspecialchars($_GET['message']);
            }
            ?>
        </div>
        <div class="toggle-form" id="toggle-text" onclick="toggleForm()">Don't have an account? Sign up here.</div>
    </div>
</body>
</html>
