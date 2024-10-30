<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirect to login if not logged in
    exit();
}
include 'db_connection.php';

// Fetch the last 3 mood entries for the user to show on the home page
$user_id = $_SESSION['user_id'];
$sql = "SELECT mood, entry_date FROM moods WHERE user_id = ? ORDER BY entry_date DESC LIMIT 3";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($mood, $entry_date);

$mood_logs = [];
while ($stmt->fetch()) {
    $mood_logs[] = ['mood' => $mood, 'date' => $entry_date];
}
$stmt->close();

// Fetch the current ongoing goal for the user
$sql_goal = "SELECT goal FROM goals WHERE user_id = ? AND status = 'ongoing' ORDER BY created_at DESC LIMIT 1";
$stmt_goal = $conn->prepare($sql_goal);
$stmt_goal->bind_param("i", $user_id);
$stmt_goal->execute();
$stmt_goal->bind_result($goal);
$stmt_goal->fetch();
$stmt_goal->close();
$conn->close();

// Define an array mapping moods to emojis (if needed)
$mood_emojis = [
    'Happy' => '😊',
    'Sad' => '😢',
    'Stressed' => '😫',
    'Excited' => '😃',
    'Calm' => '😌'
];

// Fetch the user's username from the session
$username = $_SESSION['username'];

// Dynamic Greeting based on time of day
$hour = date('H');
if ($hour >= 5 && $hour < 12) {
    $greeting = "Good Morning";
} elseif ($hour >= 12 && $hour < 17) {
    $greeting = "Good Afternoon";
} else {
    $greeting = "Good Evening";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home - Te Hauora o Te Hinengaro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Default Styles -->
    <link rel="stylesheet" href="Css/style.css">
    <!-- Home Page Styles -->
    <link rel="stylesheet" href="Css/home.css">
</head>
<body>

    <!-- Include the Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1><?php echo $greeting; ?>, <?php echo htmlspecialchars($username); ?>!</h1>
            <p>Your platform for tracking and improving your mental wellness, grounded in the principles of Partnership, Participation, and Protection.</p>
            <a href="mood-tracking.php" class="btn btn-custom">Get Started</a>
            <a href="https://www.youtube.com/watch?v=aXItOY0sLRY" target="_blank" class="btn btn-outline-light">Watch Video</a>
        </div>
    </section>

    <!-- Feature Section with Bootstrap Grid -->
    <section class="feature-section">
        <div class="container">
            <div class="row">
                <!-- Mood Tracking -->
                <div class="col-md-4">
                    <div class="feature-box">
                        <img src="Img/mood-tracking.png" alt="Mood Tracking">
                        <h4>Mood Tracking</h4>
                        <p>Monitor your mood and emotional patterns over time.</p>
                        <a href="mood-tracking.php" class="btn btn-primary">Track Your Mood</a>
                        <!-- Show recent mood logs -->
                        <ul class="list-group mt-3">
                            <?php if (!empty($mood_logs)) { 
                                foreach ($mood_logs as $log) { ?>
                                    <li class="list-group-item">
                                        <strong><?php echo htmlspecialchars($log['date']); ?>:</strong>
                                        <?php echo htmlspecialchars($log['mood']); ?>
                                    </li>
                                <?php } 
                            } else { ?>
                                <li class="list-group-item">No recent mood entries found.</li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

                <!-- Goal Setting -->
                <div class="col-md-4">
                    <div class="feature-box">
                        <img src="Img/goal-setting.png" alt="Goal Setting">
                        <h4>Goal Setting</h4>
                        <p>Set personal goals for improving mental wellness.</p>
                        <a href="goal-setting.php" class="btn btn-primary">Set Goals</a>
                        <!-- Display ongoing goal -->
                        <?php if (!empty($goal)) { ?>
                            <p class="mt-3"><strong>Current goal:</strong><br><i><?php echo htmlspecialchars($goal); ?></i></p>
                        <?php } else { ?>
                            <p class="mt-3"><i>No ongoing goals set.</i></p>
                        <?php } ?>
                    </div>
                </div>

                <!-- Self-Care -->
                <div class="col-md-4">
                    <div class="feature-box">
                        <img src="Img/self-care.png" alt="Self-Care">
                        <h4>Self-Care</h4>
                        <p>Receive personalized self-care suggestions tailored to your needs.</p>
                        <a href="self-care.php" class="btn btn-primary">Explore Self-Care</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <h2>What Our Users Say</h2>
        <div class="testimonial-item">
            <p>"Te Hauora o Te Hinengaro has been a game-changer for me. Tracking my mood and setting personal goals has significantly improved my mental well-being."</p>
            <div class="author">- Alex M.</div>
        </div>
        <div class="testimonial-item">
            <p>"The self-care suggestions are personalized and practical. I've found new ways to manage stress and stay positive."</p>
            <div class="author">- Jamie L.</div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Te Hauora o Te Hinengaro. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>
