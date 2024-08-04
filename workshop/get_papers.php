<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
require 'db_connection.php';

header('Content-Type: application/json');

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

$data = json_decode(file_get_contents('php://input'), true);
$facultyName = isset($data['faculty_name']) ? $data['faculty_name'] : '';

// Get the current month and year
$currentMonth = date('m'); // Current month (01 to 12)
$currentYear = date('Y');  // Current year (e.g., 2024)

if ($userRole == 'HOD') {
    // Fetch HOD's department
    $query = $conn->prepare("SELECT department FROM users WHERE id = ?");
    $query->bind_param('i', $userId);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();
    $department = $user['department'];

    if (!empty($facultyName)) {
        $query = $conn->prepare("SELECT * FROM papers 
            WHERE user_id IN (SELECT id FROM users WHERE department = ? AND username LIKE ?) 
            AND MONTH(created_at) = ? AND YEAR(created_at) = ?
            ORDER BY created_at DESC");
        $likeFacultyName = "%" . $facultyName . "%";
        $query->bind_param('ssii', $department, $likeFacultyName, $currentMonth, $currentYear);
    } else {
        $query = $conn->prepare("SELECT * FROM papers 
            WHERE user_id IN (SELECT id FROM users WHERE department = ?) 
            AND MONTH(created_at) = ? AND YEAR(created_at) = ?
            ORDER BY created_at DESC");
        $query->bind_param('sii', $department, $currentMonth, $currentYear);
    }
} else {
    if (!empty($facultyName)) {
        $query = $conn->prepare("SELECT * FROM papers 
            WHERE user_id = ? AND user_id IN (SELECT id FROM users WHERE username LIKE ?) 
            AND MONTH(created_at) = ? AND YEAR(created_at) = ?
            ORDER BY created_at DESC");
        $likeFacultyName = "%" . $facultyName . "%";
        $query->bind_param('isii', $userId, $likeFacultyName, $currentMonth, $currentYear);
    } else {
        $query = $conn->prepare("SELECT * FROM papers 
            WHERE user_id = ? 
            AND MONTH(created_at) = ? AND YEAR(created_at) = ?
            ORDER BY created_at DESC");
        $query->bind_param('iii', $userId, $currentMonth, $currentYear);
    }
}

$query->execute();
$result = $query->get_result();
$papers = $result->fetch_all(MYSQLI_ASSOC);

// Check if any papers were found
if (empty($papers)) {
    // No papers submitted this month
    echo json_encode(['success' => true, 'message' => 'Please upload a paper this month.']);
} else {
    echo json_encode(['success' => true, 'papers' => $papers]);
}
?>
