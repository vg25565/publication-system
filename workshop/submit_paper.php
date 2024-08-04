<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
require 'db_connection.php';  // Ensure you have your database connection here

header('Content-Type: application/json');

// Get the authorization header
$headers = apache_request_headers();
$authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

list($jwt) = sscanf($authHeader, 'Bearer %s');

if ($jwt) {
    try {
        $key = "abcd123";
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        $userId = $decoded->sub;

        // Get the paper details from the request
        $data = json_decode(file_get_contents('php://input'), true);
        $title = $data['title'];
        $status = $data['status'];
        $abstract = $data['abstract'];

        // Insert the new paper into the database
        $query = $conn->prepare("INSERT INTO papers (user_id, title, abstract, state) VALUES (?, ?, ?, ?)");
        $query->bind_param('isss', $userId, $title, $abstract, $status);

        if ($query->execute()) {
            echo json_encode(['success' => true, 'message' => 'Paper submitted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to submit paper']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Invalid token']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Token not provided']);
}
?>
