<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
require 'db_connection.php';  // Ensure you have your database connection here

header('Content-Type: application/json');

$headers = apache_request_headers();
$authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

list($jwt) = sscanf($authHeader, 'Bearer %s');

if ($jwt) {
    try {
        $key = "abcd123";
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        $userId = $decoded->sub;

        $query = $conn->prepare("SELECT * FROM papers WHERE user_id = ?");
        $query->bind_param('i', $userId);
        $query->execute();
        $result = $query->get_result();

        $papers = [];
        while ($row = $result->fetch_assoc()) {
            $papers[] = $row;
        }

        echo json_encode(['success' => true, 'papers' => $papers]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Invalid token']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Token not provided']);
}
?>
