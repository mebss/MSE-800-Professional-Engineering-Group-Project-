<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
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
        $message = "SQL Error (Insert): " . $conn->error;
    }
}

// Handle goal completion
if (isset($_GET['complete_goal_id'])) {
    $goal_id = $_GET['complete_goal_id'];

    // Update the status of the goal to "completed"
    $sql = "UPDATE goals SET status = 'completed', completed_at = NOW() WHERE id = ? AND user_id = ?";
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
        $message = "SQL Error (Update): " . $conn->error;
    }
}

// Fetch ongoing goals
$sql = "SELECT id, goal FROM goals WHERE user_id = ? AND status = 'ongoing' ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement for ongoing goals: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($goal_id, $goal);
$ongoing_goals = [];
while ($stmt->fetch()) {
    $ongoing_goals[] = ['id' => $goal_id, 'goal' => $goal];
}
$stmt->close();

// Fetch completed goals
$sql = "SELECT goal, completed_at FROM goals WHERE user_id = ? AND status = 'completed' ORDER BY completed_at DESC";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Error preparing statement for completed goals: " . $conn->error);
}
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
    <!-- ... other head elements ... -->
    <title>Goal Setting - Te Hauora o Te Hinengaro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Default Styles -->
    <link rel="stylesheet" href="Css/style.css">
    <!-- Goal Setting Page Styles -->
    <link rel="stylesheet" href="Css/goal-setting.css">
</head>
<body>

    <!-- Include the Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Hero Section -->
    <div class="hero-section">
        <h2>Set Your Goals</h2>
        <p>Empower your journey towards better mental wellness</p>
    </div>

    <!-- New Goal Form -->
    <div class="new-goal-form">
        <?php if (!empty($message)) { ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php } ?>
        <form method="POST" action="goal-setting.php">
            <div class="mb-3">
                <label for="goal" class="form-label">What goal would you like to set?</label>
                <input type="text" name="goal" id="goal" class="form-control" required placeholder="e.g., Practice mindfulness daily">
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-plus-circle"></i> Add Goal</button>
        </form>
    </div>

    <!-- Ongoing Goals -->
    <div class="goals-list">
        <h4><i class="fas fa-tasks"></i> Ongoing Goals</h4>
        <ul class="list-group">
            <?php if (!empty($ongoing_goals)) {
                foreach ($ongoing_goals as $goal) { ?>
                    <li class="list-group-item">
                        <div class="goal-text"><?php echo htmlspecialchars($goal['goal']); ?></div>
                        <a href="goal-setting.php?complete_goal_id=<?php echo $goal['id']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-check"></i> Complete</a>
                    </li>
                <?php } 
            } else { ?>
                <li class="list-group-item">You have no ongoing goals.</li>
            <?php } ?>
        </ul>
    </div>

    <!-- Completed Goals -->
    <div class="goals-list">
        <h4><i class="fas fa-check-circle"></i> Completed Goals</h4>
        <ul class="list-group">
            <?php if (!empty($completed_goals)) {
                foreach ($completed_goals as $goal) { ?>
                    <li class="list-group-item">
                        <div class="goal-text">
                            <?php echo htmlspecialchars($goal['goal']); ?>
                            <span class="text-muted">Completed on <?php echo date("F j, Y", strtotime($goal['date'])); ?></span>
                        </div>
                        <i class="fas fa-check-circle" style="color: #004d40; font-size: 1.5em;"></i>
                    </li>
                <?php } 
            } else { ?>
                <li class="list-group-item">You have no completed goals.</li>
            <?php } ?>
        </ul>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Te Hauora o Te Hinengaro. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>
