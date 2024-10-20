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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goal Setting - Te Hauora o Te Hinengaro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Include the Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Goal Setting Section -->
    <div class="container mt-5">
        <h2>Goal Setting</h2>
        <p>Set personal goals to improve your mental wellness and track your progress over time.</p>

        <?php if (!empty($message)) { ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php } ?>

        <!-- New Goal Form -->
        <form method="POST" action="goal-setting.php" class="mb-4">
            <div class="mb-3">
                <label for="goal" class="form-label">What goal would you like to set?</label>
                <input type="text" name="goal" id="goal" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Add Goal</button>
        </form>

        <!-- Ongoing Goals -->
        <h4>Ongoing Goals</h4>
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

        <!-- Completed Goals -->
        <h4>Completed Goals</h4>
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
    </div>

    <!-- Footer -->
    <footer class="mt-auto">
        <p>&copy; 2024 Te Hauora o Te Hinengaro. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
