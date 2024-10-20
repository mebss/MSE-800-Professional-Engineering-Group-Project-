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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Te Hauora o Te Hinengaro</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Include the Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Banner Section -->
    <section class="banner">
        <div class="container">
            <h1>Welcome to Te Hauora o Te Hinengaro, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>Your platform for tracking and improving your mental wellness, grounded in the principles of Partnership, Participation, and Protection.</p>
            <a href="mood-tracking.php" class="btn btn-custom">Get Started</a>
            <a href="https://www.youtube.com/watch?v=aXItOY0sLRY" target="_blank" class="btn btn-outline-light">Watch Video</a>
            <img src="Img\image.jpg" alt="Mental Wellness" class="img-fluid mt-3" style="border-radius: 10px; width: 100%; max-height: 400px; object-fit: cover;">
        </div>
    </section>

    <!-- Feature Section with Bootstrap Grid -->
    <section class="feature-section">
        <div class="container">
            <div class="row">
                <!-- Mood Tracking -->
                <div class="col-md-4">
                    <div class="feature-box p-3">
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
                    <div class="feature-box p-3">
                        <h4>Goal Setting</h4>
                        <p>Set personal goals for improving mental wellness.</p>
                        <a href="goal-setting.php" class="btn btn-primary">Set Goals</a>
                        <!-- Display ongoing goal -->
                        <?php if (!empty($goal)) { ?>
                            <p class="mt-3"><strong>Current goal:</strong> <br> <i><?php echo htmlspecialchars($goal); ?></i></p>
                        <?php } else { ?>
                            <p class="mt-3"><i>No ongoing goals set.</i></p>
                        <?php } ?>
                    </div>
                </div>

                <!-- Self-Care -->
                <div class="col-md-4">
                    <div class="feature-box p-3">
                        <h4>Self-Care</h4>
                        <p>Receive personalized self-care suggestions tailored to your needs.</p>
                        <a href="self-care.php" class="btn btn-primary">Explore Self-Care</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Te Hauora o Te Hinengaro. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
