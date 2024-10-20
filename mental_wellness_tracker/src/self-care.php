<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include 'db_connection.php';

$user_id = $_SESSION['user_id'];
$message = "";

// Fetch self-care suggestions from the database based on categories
$categories = ['Physical', 'Emotional', 'Mental', 'Spiritual'];
$self_care_suggestions = [];

// Loop through each category to fetch the suggestions
foreach ($categories as $category) {
    $sql = "SELECT suggestion FROM self_care_suggestions WHERE category = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $stmt->bind_result($suggestion);
        $suggestions = [];
        while ($stmt->fetch()) {
            $suggestions[] = $suggestion;
        }
        $self_care_suggestions[$category] = $suggestions;
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Self-Care - Te Hauora o Te Hinengaro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Include the Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Self-Care Section -->
    <div class="container mt-5">
        <h2>Self-Care</h2>
        <p>Explore personalized self-care suggestions and tips to improve your mental and emotional well-being.</p>

        <div class="row">
            <?php foreach ($categories as $category) { ?>
                <div class="col-md-6">
                    <h4><?php echo htmlspecialchars($category); ?> Self-Care</h4>
                    <ul class="list-group mb-4">
                        <?php if (!empty($self_care_suggestions[$category])) {
                            foreach ($self_care_suggestions[$category] as $suggestion) { ?>
                                <li class="list-group-item"><?php echo htmlspecialchars($suggestion); ?></li>
                            <?php }
                        } else { ?>
                            <li class="list-group-item">No suggestions available for this category.</li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>

        <!-- Resources Section -->
        <h4>Additional Resources</h4>
        <ul class="list-group mb-4">
            <li class="list-group-item"><a href="https://www.verywellmind.com/practice-5-minute-meditation-3144714"target="_blank">5-Minute Meditation Techniques</a></li>
            <li class="list-group-item"><a href="https://health.clevelandclinic.org/how-to-start-a-self-care-routine"target="_blank">How to Create a Self-Care Routine</a></li>
            <li class="list-group-item"><a href="https://www.helpguide.org/wellness/fitness/the-mental-health-benefits-of-exercise"target="_blank">The Benefits of Physical Exercise for Mental Health</a></li>
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
