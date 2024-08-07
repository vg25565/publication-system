<?php
require 'db_connection.php';  // Ensure you have your database connection here


$sql = "CREATE TABLE IF NOT EXISTS papers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    abstract TEXT,
    state ENUM('submitted', 'accepted', 'rejected') NOT NULL DEFAULT 'submitted',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'papers' created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>
