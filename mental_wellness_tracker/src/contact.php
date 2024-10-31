<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags and title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Te Hauora o Te Hinengaro</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="Css/contact.css">
</head>
<body>
    <!-- Include the Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Hero Banner -->
    <div class="contact-banner">
        <div class="container">
            <h1>Contact Us</h1>
            <p>We are here to help. Reach out to us anytime.</p>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-fill">
        <!-- Contact Section -->
        <div class="container mt-5">
            <p>Here are some key mental health services and support lines in New Zealand:</p>

            <div class="row">
                <!-- Immediate Support Contacts -->
                <div class="col-md-6">
                    <h4>Immediate Support Contacts</h4>

                    <!-- 1737 – Need to Talk? -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-phone-alt"></i> 1737 – Need to Talk?</h5>
                            <p class="card-text">
                                Call or text <strong>1737</strong> to talk to a trained counsellor 24/7.
                            </p>
                            <a href="https://1737.org.nz" target="_blank" class="btn btn-custom">
                                <i class="fas fa-external-link-alt"></i> Visit Website
                            </a>
                        </div>
                    </div>

                    <!-- Lifeline -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-phone-alt"></i> Lifeline</h5>
                            <p class="card-text">
                                Call <strong>0800 543 354</strong> or text <strong>4357</strong> for free, confidential support.
                            </p>
                            <a href="https://www.lifeline.org.nz/" target="_blank" class="btn btn-custom">
                                <i class="fas fa-external-link-alt"></i> Visit Website
                            </a>
                        </div>
                    </div>

                    <!-- Suicide Crisis Helpline -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-phone-alt"></i> Suicide Crisis Helpline</h5>
                            <p class="card-text">
                                Call <strong>0508 828 865</strong> (0508 TAUTOKO) for help in a crisis.
                            </p>
                            <a href="https://www.lifeline.org.nz/services/suicide-crisis-helpline/" target="_blank" class="btn btn-custom">
                                <i class="fas fa-external-link-alt"></i> Visit Website
                            </a>
                        </div>
                    </div>

                    <!-- Youthline -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-phone-alt"></i> Youthline</h5>
                            <p class="card-text">
                                Call <strong>0800 376 633</strong> or text <strong>234</strong>.
                            </p>
                            <a href="https://www.youthline.co.nz/" target="_blank" class="btn btn-custom">
                                <i class="fas fa-external-link-alt"></i> Visit Website
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Additional Mental Health Resources -->
                <div class="col-md-6">
                    <h4>Additional Mental Health Resources</h4>

                    <!-- Mental Health Foundation -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-globe"></i> Mental Health Foundation</h5>
                            <p class="card-text">
                                Provides information and support for mental wellbeing.
                            </p>
                            <a href="https://mentalhealth.org.nz/" target="_blank" class="btn btn-custom">
                                <i class="fas fa-external-link-alt"></i> Visit Website
                            </a>
                        </div>
                    </div>

                    <!-- Anxiety NZ -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-heartbeat"></i> Anxiety NZ</h5>
                            <p class="card-text">
                                Specialist support for anxiety-related issues. Call <strong>0800 269 4389</strong>.
                            </p>
                            <a href="https://anxiety.org.nz/" target="_blank" class="btn btn-custom">
                                <i class="fas fa-external-link-alt"></i> Visit Website
                            </a>
                        </div>
                    </div>

                    <!-- Samaritans NZ -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-hand-holding-heart"></i> Samaritans NZ</h5>
                            <p class="card-text">
                                Call <strong>0800 726 666</strong> for confidential support.
                            </p>
                            <a href="https://www.samaritans.org.nz/" target="_blank" class="btn btn-custom">
                                <i class="fas fa-external-link-alt"></i> Visit Website
                            </a>
                        </div>
                    </div>
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
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Your Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Your Message</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-comment"></i></span>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-custom"><i class="fas fa-paper-plane"></i> Send Message</button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Te Hauora o Te Hinengaro. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
