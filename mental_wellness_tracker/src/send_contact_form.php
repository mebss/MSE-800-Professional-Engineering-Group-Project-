<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message_content = htmlspecialchars($_POST['message']);

    // Define recipient and subject
    $to = "testingforapplications@outlook.com"; 
    $subject = "New Contact Form Submission from $name";

    // Define the email body
    $message = "You have received a new message from $name.\n\n";
    $message .= "Email: $email\n\n";
    $message .= "Message:\n$message_content\n";

    // Email headers
    $headers = "From: noreply@yourdomain.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        // Redirect back to the contact page with success
        header("Location: contact.php?success=1");
        exit();
    } else {
        // Redirect back to the contact page with error
        header("Location: contact.php?error=1");
        exit();
    }
}
?>
