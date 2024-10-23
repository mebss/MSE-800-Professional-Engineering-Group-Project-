<?php
$servername = "db";  // Docker service name for MySQL
$username = "root";  // Default MySQL root user
$password = "lisbeth369";  // Password as defined in docker-compose.yml
$dbname = "mental_wellness_tracker";  // Database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optionally, you can check and create tables here again (not mandatory since init.sql already handles it)
?>
