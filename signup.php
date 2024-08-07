<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
require 'db_connection.php';

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);


error_log(print_r($data, true));

$username = $data['username'] ?? null;
$password = $data['password'] ?? null;
$firstName = $data['firstName'] ?? null;
$lastName = $data['lastName'] ?? null;
$Department  = $data['Department'] ?? null;


if (empty($username)) {
    echo json_encode(['success' => false, 'message' => '1']);
    exit();
}
if (empty($password)) {
    echo json_encode(['success' => false, 'message' => '2']);
    exit();
}
if (empty($lastName)) {
    echo json_encode(['success' => false, 'message' => '4']);
    exit();
}
if (empty($firstName)) {
    echo json_encode(['success' => false, 'message' => '3']);
    exit(); 
}


// Check if username already exists
$query = $conn->prepare("SELECT * FROM users WHERE username = ?");
$query->bind_param('s', $username);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Username already exists']);
    exit();
}


$query = $conn->prepare("INSERT INTO users (username, password, firstName, lastName, department) VALUES (?, ?, ?, ?, ?)");
$query->bind_param('sssss', $username, $password, $firstName, $lastName, $Department);

if ($query->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Signup failed']);
}
?>
