<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row["password"])) {
            echo "Login successful!";
            header("Location: welcome.html");  // Redirect to a welcome page (create this page separately)
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with that email!";
    }

    $conn->close();
}
?>
    