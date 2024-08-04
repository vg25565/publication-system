<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
require 'db_connection.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'];
$password = $data['password'];

$query = $conn->prepare("SELECT * FROM users WHERE username = ?");
$query->bind_param('s', $username);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Username already exists']);
    exit();
}

// Insert new user into database
$query = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$query->bind_param('ss', $username, $password);
if ($query->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Signup failed']);
}
?>
