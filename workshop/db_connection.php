<?php
$servername = "localhost";
$username = "root"; // replace with your MySQL username
$password = ""; // replace with your MySQL password
$dbname = "publication"; // replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
