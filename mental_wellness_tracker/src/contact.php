<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Te Hauora o Te Hinengaro</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Include the Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Contact Section -->
    <div class="container mt-5">
        <h2>Contact Us</h2>
        <p>Here are some key mental health services and support lines in New Zealand:</p>

        <div class="row">
            <div class="col-md-6">
                <h4>Immediate Support Contacts</h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>1737 – Need to Talk?</strong><br>
                        Call or text <strong>1737</strong> to talk to a trained counsellor 24/7.<br>
                        <a href="https://1737.org.nz" target="_blank">Visit Website</a>
                    </li>
                    <li class="list-group-item">
                        <strong>Lifeline</strong><br>
                        Call <strong>0800 543 354</strong> or text <strong>4357</strong> for free, confidential support.<br>
                        <a href="https://www.lifeline.org.nz/" target="_blank">Visit Website</a>
                    </li>
                    <li class="list-group-item">
                        <strong>Suicide Crisis Helpline</strong><br>
                        Call <strong>0508 828 865</strong> (0508 TAUTOKO) for help in a crisis.<br>
                        <a href="https://www.lifeline.org.nz/services/suicide-crisis-helpline/" target="_blank">Visit Website</a>
                    </li>
                    <li class="list-group-item">
                        <strong>Youthline</strong><br>
                        Call <strong>0800 376 633</strong> or text <strong>234</strong>.<br>
                        <a href="https://www.youthline.co.nz/" target="_blank">Visit Website</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-6">
                <h4>Additional Mental Health Resources</h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Mental Health Foundation</strong><br>
                        Provides information and support for mental wellbeing.<br>
                        <a href="https://mentalhealth.org.nz/" target="_blank">Visit Website</a>
                    </li>
                    <li class="list-group-item">
                        <strong>Anxiety NZ</strong><br>
                        Specialist support for anxiety-related issues.<br>
                        Call <strong>0800 269 4389</strong>.<br>
                        <a href="https://anxiety.org.nz/" target="_blank">Visit Website</a>
                    </li>
                    <li class="list-group-item">
                        <strong>Samaritans NZ</strong><br>
                        Call <strong>0800 726 666</strong> for confidential support.<br>
                        <a href="https://www.samaritans.org.nz/" target="_blank">Visit Website</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Display success or error messages after form submission -->
        <?php
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo "<div class='alert alert-success mt-4'>Your message has been sent successfully!</div>";
        } elseif (isset($_GET['error']) && $_GET['error'] == 1) {
            echo "<div class='alert alert-danger mt-4'>There was an error sending your message. Please try again later.</div>";
        }
        ?>

        <!-- Contact Form -->
        <h4 class="mt-5">Get in Touch with Us</h4>
        <form method="POST" action="send_contact_form.php" class="mb-5">
            <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Your Message</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Send Message</button>
        </form>
    </div>

    <!-- Footer -->
    <footer class="mt-auto">
        <p>&copy; 2024 Te Hauora o Te Hinengaro. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
