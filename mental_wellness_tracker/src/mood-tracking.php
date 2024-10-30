<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include 'db_connection.php';

// Fetch the user's mood entries
$user_id = $_SESSION['user_id'];
$message = "";

// Handle mood logging
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['mood'])) {
        $mood = $_POST['mood'];
        $entry_date = date('Y-m-d'); // Today's date

        // Insert the mood into the database
        $sql = "INSERT INTO moods (user_id, mood, entry_date) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        // Check if statement prepared successfully
        if (!$stmt) {
            die("SQL Error: " . $conn->error); // Output detailed SQL error
        }

        $stmt->bind_param("iss", $user_id, $mood, $entry_date);
        if ($stmt->execute()) {
            $message = "Mood logged successfully!";
        } else {
            $message = "Error logging mood: " . $conn->error;
        }
        $stmt->close();
    }
}

// Fetch all mood logs for the user (limit to the last 7 entries for chart display)
$sql = "SELECT mood, entry_date FROM moods WHERE user_id = ? ORDER BY entry_date DESC LIMIT 7";
$stmt = $conn->prepare($sql);

// Check if statement prepared successfully
if (!$stmt) {
    die("SQL Error: " . $conn->error); // Output detailed SQL error
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($mood, $entry_date);

$mood_logs = [];
while ($stmt->fetch()) {
    $mood_logs[] = ['mood' => $mood, 'date' => $entry_date];
}
$stmt->close();
$conn->close();

// Define an array mapping moods to emojis
$mood_emojis = [
    'Happy' => '😊',
    'Sad' => '😢',
    'Stressed' => '😫',
    'Excited' => '😃',
    'Calm' => '😌'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Tracking - Te Hauora o Te Hinengaro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Default Styles -->
    <link rel="stylesheet" href="Css/style.css">
    <!-- Mood Tracking Page Styles -->
    <link rel="stylesheet" href="Css/mood-tracking.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <!-- Include the Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Mood Tracking Section -->
    <div class="container mood-container">
        <h2>Mood Tracking</h2>
        <p>Track your mood over time to identify patterns and emotional trends.</p>

        <?php if (!empty($message)) { ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php } ?>

        <!-- Mood logging form -->
        <div class="mood-form">
            <form method="POST" action="mood-tracking.php">
                <div class="mb-3">
                    <label for="mood" class="form-label">How do you feel today?</label>
                    <select name="mood" id="mood" class="form-select" required>
                        <option value="Happy">😊 Happy</option>
                        <option value="Sad">😢 Sad</option>
                        <option value="Stressed">😫 Stressed</option>
                        <option value="Excited">😃 Excited</option>
                        <option value="Calm">😌 Calm</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Log Mood</button>
            </form>
        </div>

        <!-- Display mood logs -->
        <div class="mood-log">
            <h4>Your Mood Log</h4>
            <ul class="list-group mb-4">
                <?php if (!empty($mood_logs)) { 
                    foreach ($mood_logs as $log) { ?>
                        <li class="list-group-item">
                            <strong><?php echo htmlspecialchars($log['date']); ?>:</strong>
                            <span><?php echo $mood_emojis[$log['mood']] . ' ' . htmlspecialchars($log['mood']); ?></span>
                        </li>
                    <?php } 
                } else { ?>
                    <li class="list-group-item">No mood entries logged yet.</li>
                <?php } ?>
            </ul>
        </div>

        <!-- Chart Section -->
        <div class="chart-section">
            <h4>Your Mood Trend</h4>
            <canvas id="moodChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Te Hauora o Te Hinengaro. All Rights Reserved.</p>
    </footer>

    <script>
        // Prepare mood data for the chart
        const moodData = <?php echo json_encode(array_reverse($mood_logs)); ?>;

        // Map moods to numerical scores and emojis
        const moodMap = {
            'Happy': { score: 5, emoji: '😊' },
            'Excited': { score: 4, emoji: '😃' },
            'Calm': { score: 3, emoji: '😌' },
            'Stressed': { score: 2, emoji: '😫' },
            'Sad': { score: 1, emoji: '😢' }
        };

        const dates = moodData.map(log => log.date);
        const moodScores = moodData.map(log => moodMap[log.mood].score);

        const moodEmojis = {
            1: '😢',
            2: '😫',
            3: '😌',
            4: '😃',
            5: '😊'
        };

        // Create the chart
        const ctx = document.getElementById('moodChart').getContext('2d');
        const moodChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Mood Score',
                    data: moodScores,
                    backgroundColor: 'rgba(0, 150, 136, 0.2)',
                    borderColor: 'rgba(0, 150, 136, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                return moodEmojis[value] || '';
                            }
                        },
                        min: 1,
                        max: 5
                    }
                },
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    }
                }
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>
