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
			header("Location: mood-tracking.php#one");
			exit();
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
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Photon by HTML5 UP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="assets1/css/main.css" />
		<link rel="stylesheet" href="style.css">
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	</head>
	<body class="is-preload">

    <!-- Include the Navbar -->
    <?php include 'navbar.php'; ?>
		<!-- Header -->
			<section id="header">
				<div class="inner">
					<span class="icon solid major fa-cloud"></span>
					<h1>Welcome to Your<strong>Mood Tracker</strong><br />
					</h1>
					<p>Track your mood over time to identify patterns and emotional trends.</p>
					<ul class="actions special">
   					 	<li><a href="#one" class="button scrolly">Log mood</a></li>
					</ul>
				</div>
			</section>
		<?php if (!empty($message)) { ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php } ?>
		<!-- One -->
		<section id="one" class="main style1">
    <div class="container">
        <div class="row gtr-150">
            <div class="col-6 col-12-medium">
                <!-- Form to submit mood to mood-tracking.php -->
                <form method="POST" action="mood-tracking.php#one"  class="mb-4">
                    <div class="mb-3">
                        <label for="mood" class="form-label">How do you feel today?</label>
                        <select name="mood" id="mood" class="form-select" required>
                            <option value="Happy">😊 Happy</option>
                            <option value="Sad">😢 Sad</option>
                            <option value="Stressed">😣 Stressed</option>
                            <option value="Excited">🤩 Excited</option>
                            <option value="Calm">😌 Calm</option>
                        </select>
                    </div>
                    <!-- Submit button that sends form data to mood-tracking.php -->
                    <button type="submit" class="btn btn-success w-100">Log Mood</button>
                </form>
            </div>

            <!-- Display mood entries -->
            <div class="col-6 col-12-medium imp-medium">
                <div class="card-deck mb-4">
                    <?php if (!empty($mood_logs)) { 
                        foreach ($mood_logs as $log) { ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($log['date']); ?></h5>
                                    <p class="card-text"><?php echo htmlspecialchars($log['mood']); ?></p>
                                </div>
                            </div>
                        <?php } 
                    } else { ?>
                        <div class="alert alert-warning">No mood entries logged yet.</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
		<!-- Two -->
			<section id="two" class="main style2">
				<div class="container">
					<div class="row gtr-150">
						
						<div class="col-12">
							<header class="major">
								<h4>Your Mood Trend</h4>
							</header>
							<canvas id="moodChart" width="100%"></canvas>
						</div>
					</div>
				</div>
			</section>
			<!-- Footer -->
	<footer class="mt-auto">
        <p>&copy; 2024 Te Hauora o Te Hinengaro. All Rights Reserved.</p>
    </footer>

		<!-- Scripts -->
				<script>
				// Prepare mood data for the chart
				const moodData = <?php echo json_encode(array_reverse($mood_logs)); ?>;

				// Convert moods to a numerical scale
				const moodMap = {
					'Happy': 5,
					'Excited': 4,
					'Calm': 3,
					'Stressed': 2,
					'Sad': 1
				};

				const dates = moodData.map(log => log.date);
				const moodScores = moodData.map(log => moodMap[log.mood]);

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
						}]
					},
					options: {
						scales: {
							y: {
								beginAtZero: true,
								ticks: {
									stepSize: 1,
									callback: function(value) {
										switch(value) {
											case 5: return 'Happy';
											case 4: return 'Excited';
											case 3: return 'Calm';
											case 2: return 'Stressed';
											case 1: return 'Sad';
										}
									}
								}
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

			<script src="assets1/js/jquery.min.js"></script>
			<script src="assets1/js/jquery.scrolly.min.js"></script>
			<script src="assets1/js/browser.min.js"></script>
			<script src="assets1/js/breakpoints.min.js"></script>
			<script src="assets1/js/util.js"></script>
			<script src="assets1/js/main.js"></script>    
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

			

	</body>
</html>