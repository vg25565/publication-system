<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testdb"; // Changed database name to testdb

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$form_type = $_POST['form-type'];
$username = $_POST['username'];
$password = $_POST['password'];

if ($form_type === "login") {
    // Process login
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        header("Location: login-success.php");
        exit();
    } else {
        header("Location: index.php?message=Invalid username or password");
        exit();
    }
} elseif ($form_type === "signup") {
    // Process sign-up
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?message=Sign Up successful");
        exit();
    } else {
        header("Location: index.php?message=Error: " . $conn->error);
        exit();
    }
}

$conn->close();
?>
