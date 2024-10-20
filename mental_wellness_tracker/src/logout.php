<?php
session_start();
// Destroy the session to log the user out
session_destroy();
header("Location: index.html"); // Redirect to login page after logout
exit();
?>
