<?php
$servername = "db";
$username = "root";
$password = "mehrab";
$dbname = "mental_wellness_tracker";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
