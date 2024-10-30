<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include 'db_connection.php';

$user_id = $_SESSION['user_id'];
$message = "";

// Handle new goal submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['goal'])) {
    $goal = $_POST['goal'];
    $status = "ongoing"; // By default, goals are ongoing when created

    // Insert the new goal into the database
    $sql = "INSERT INTO goals (user_id, goal, status) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iss", $user_id, $goal, $status);
        if ($stmt->execute()) {
            $message = "Goal added successfully!";
            header("Location: goal-setting.php#ongoing-goals");
            exit();
        } else {
            $message = "Error adding goal: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "SQL Error: " . $conn->error;
    }
}

// Handle goal completion
if (isset($_GET['complete_goal_id'])) {
    $goal_id = $_GET['complete_goal_id'];

    // Update the status of the goal to "completed"
    $sql = "UPDATE goals SET status = 'completed' WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $goal_id, $user_id);
        if ($stmt->execute()) {
            $message = "Goal marked as completed!";
            header("Location: goal-setting.php#completed-goals"); // Redirect with anchor
            exit();
        } else {
            $message = "Error completing goal: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "SQL Error: " . $conn->error;
    }
}

// Fetch ongoing goals
$sql = "SELECT id, goal FROM goals WHERE user_id = ? AND status = 'ongoing' ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($goal_id, $goal);
$ongoing_goals = [];
while ($stmt->fetch()) {
    $ongoing_goals[] = ['id' => $goal_id, 'goal' => $goal];
}
$stmt->close();

// Fetch completed goals
$sql = "SELECT goal, created_at FROM goals WHERE user_id = ? AND status = 'completed' ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($completed_goal, $completion_date);
$completed_goals = [];
while ($stmt->fetch()) {
    $completed_goals[] = ['goal' => $completed_goal, 'date' => $completion_date];
}
$stmt->close();

$conn->close();
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Goal Setting</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="assets2/css/main.css" />
        <link rel="stylesheet" href="style.css">
	</head>
	<body class="index is-preload">
		<!-- Include the Navbar -->
		<?php include 'navbar.php'; ?>

		<div id="page-wrapper">
			<!-- Banner -->
				<section id="banner">
					<div class="inner">

						<header>
							<h2>Goal Setting</h2>
						</header>
						<p>Set personal <strong>goals</strong> <br />
							to improve your mental wellness
						<br />
						and track your progress over time.
						<br />
						<footer>
							<ul class="buttons stacked">
								<li><a href="#main" class="button fit scrolly">Add Goal</a></li>
							</ul>
						</footer>
					</div>
				</section>
				<?php if (!empty($message)) { ?>
					<div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
				<?php } ?>
			<!-- Main -->
			
				<section id="main">
					<header class="special container">
						<span class="icon solid fa-chart-bar"></span>
						<h2>What <strong>goal</strong> would you like to set?
						<br /></h2>
						<!-- New Goal Form -->
						<form method="POST" action="goal-setting.php" class="mb-4">
							<div class="mb-3">
								<label for="goal" class="form-label">What goal would you like to set?</label>
								<input type="text" name="goal" id="goal" class="form-control" required>
							</div>
							<button type="submit" class="btn btn-success">Add Goal</button>
						</form>
					</header>
				</section>
					<!-- One -->
						<section id="ongoing-goals" class="wrapper style2 container special-alt">
							<div class="row gtr-50">
								<div class="col-8 col-12-narrower">

									<header>
										<h2>Ongoing <strong>Goals</strong></h2>
										<ul class="list-group mb-4">
											<?php if (!empty($ongoing_goals)) {
												foreach ($ongoing_goals as $goal) { ?>
													<li class="list-group-item">
														<?php echo htmlspecialchars($goal['goal']); ?>
														<a href="goal-setting.php?complete_goal_id=<?php echo $goal['id']; ?>" class="btn btn-sm btn-primary float-end">Mark as Complete</a>
													</li>
												<?php } 
											} else { ?>
												<li class="list-group-item">You have no ongoing goals.</li>
											<?php } ?>
										</ul>
									</header>

								</div>
								<div class="col-4 col-12-narrower imp-narrower">

									<ul class="featured-icons">
										<li><span class="icon fa-clock"><span class="label">Feature 1</span></span></li>
										<li><span class="icon solid fa-volume-up"><span class="label">Feature 2</span></span></li>
										<li><span class="icon solid fa-laptop"><span class="label">Feature 3</span></span></li>
										<li><span class="icon solid fa-inbox"><span class="label">Feature 4</span></span></li>
										<li><span class="icon solid fa-lock"><span class="label">Feature 5</span></span></li>
										<li><span class="icon solid fa-cog"><span class="label">Feature 6</span></span></li>
									</ul>

								</div>
							</div>
						</section>

					<!-- Two -->
						<section id="completed-goals" class="wrapper style1 container special">
							<div class="row">
								<div class="col-4 col-12-narrower mx-auto text-center">

									<section>
										<span class="icon solid featured fa-check"></span>
										<header>
											<h3>Completed <strong>Goals</strong></h3>
											<ul class="list-group">
												<?php if (!empty($completed_goals)) {
													foreach ($completed_goals as $goal) { ?>
														<li class="list-group-item">
															<?php echo htmlspecialchars($goal['goal']); ?>
															<span class="text-muted float-end">Completed on <?php echo htmlspecialchars($goal['date']); ?></span>
														</li>
													<?php } 
												} else { ?>
													<li class="list-group-item">You have no completed goals.</li>
												<?php } ?>
											</ul>
										</header>
						            </section>
								</div>
							</div>
						</section>

					

			<!-- Footer -->
			<footer class="mt-auto">
				<p>&copy; 2024 Te Hauora o Te Hinengaro. All Rights Reserved.</p>
			</footer>

		</div>

		<!-- Scripts -->
			<script src="assets2/js/jquery.min.js"></script>
			<script src="assets2/js/jquery.dropotron.min.js"></script>
			<script src="assets2/js/jquery.scrolly.min.js"></script>
			<script src="assets2/js/jquery.scrollex.min.js"></script>
			<script src="assets2/js/browser.min.js"></script>
			<script src="assets2/js/breakpoints.min.js"></script>
			<script src="assets2/js/util.js"></script>
			<script src="assets2/js/main.js"></script>
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	</body>
</html>