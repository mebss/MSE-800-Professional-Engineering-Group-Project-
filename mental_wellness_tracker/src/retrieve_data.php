<?php
include 'db_connection.php';

$sql = "SELECT id, mood, created_at FROM moods";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Mood: " . $row["mood"]. " - Date: " . $row["created_at"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
