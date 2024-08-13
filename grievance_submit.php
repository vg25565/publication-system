<?php
$servername = "localhost";
$username = "root";
$password = "Aayush@05";
$dbname = "form_data";

// Function to connect to the database
function connectDatabase() {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Function to insert grievance data into the database
function insertGrievance($faculty, $branch, $grievance) {
    $conn = connectDatabase();
    $sql = "INSERT INTO FacultyGrievances (faculty, branch, grievance) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $faculty, $branch, $grievance);

    if ($stmt->execute()) {
        echo "Grievance submitted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $faculty = $_POST['faculty'];
    $branch = $_POST['branch'];
    $grievance = $_POST['grievance'];
    insertGrievance($faculty, $branch, $grievance);
}
?>