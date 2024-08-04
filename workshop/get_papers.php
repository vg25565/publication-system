<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
require 'db_connection.php';

header('Content-Type: application/json');

// Get the JWT token from the request headers
$headers = getallheaders();
if (!isset($headers['Authorization'])) {
    echo json_encode(['success' => false, 'message' => 'No token provided']);
    exit();
}

$jwt = str_replace('Bearer ', '', $headers['Authorization']);
$key = "abcd123";

try {
    $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    $userId = $decoded->sub;
    $userRole = $decoded->role;
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Invalid token']);
    exit();
}

if ($userRole == 'HOD') {
    // Fetch HOD's department
    $query = $conn->prepare("SELECT department FROM users WHERE id = ?");
    $query->bind_param('i', $userId);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();
    $department = $user['department'];

    // Fetch papers from the same department
    $query = $conn->prepare("SELECT * FROM papers WHERE user_id IN (SELECT id FROM users WHERE department = ?)");
    $query->bind_param('s', $department);
} else {
    // Fetch papers by the logged-in user
    $query = $conn->prepare("SELECT * FROM papers WHERE user_id = ?");
    $query->bind_param('i', $userId);
}

$query->execute();
$result = $query->get_result();
$papers = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode(['success' => true, 'papers' => $papers]);
?>
