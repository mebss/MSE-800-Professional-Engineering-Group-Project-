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

<!DOCTYPE HTML>
<html>
	<head>
		<title>Self-Care - Te Hauora o Te Hinengaro</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="assets/css1/main.css" />
		<link rel="stylesheet" href="style.css">

	</head>
	<body class="homepage is-preload">
		<div id="page-wrapper">
		<!-- Include the Navbar -->
		<?php include 'navbar.php'; ?>
			<!-- Header -->
			 <!-- Include the Navbar -->
				<div id="header-wrapper">
					
					<!-- Hero -->
						<section id="hero" class="container">
							<header>
								<h2>Self-Care
								</h2>
							</header>
							<p>
								Explore personalized self-care suggestions and tips to improve your mental and emotional well-being.
							</p>
						</section>
				</div>
			<!-- Promo -->
				<div id="promo-wrapper">
					<section id="promo">
						<h2>Physical Self-Care
						</h2>
					</section>
				</div>
			<!-- Features 1 -->
				<div class="wrapper">
					<div class="container">
						<div class="row">
							<section class="col-6 col-12-narrower feature">
								<div class="image-wrapper first">
									<a href="#" class="image featured first"><img src="Img/pic01.jpg" alt="" /></a>
								</div>
								<header>
									<h2>Take a short walk outside<br />
										to get fresh air.</h2>
								</header>
								<p>A short stroll outside can work wonders! Fresh air, sunshine,
									 and a bit of greenery can instantly lift your mood. So, take a break, 
									 step outside, and let nature's magic brighten your day.</p>
							
							</section>
							<section class="col-6 col-12-narrower feature">
								<div class="image-wrapper">
									<a href="#" class="image featured"><img src="Img/pic02.jpg" alt="" /></a>
								</div>
								<header>
									<h2>Stay hydrated
										<br />
										and eat a balanced meal.</h2>
								</header>
								<p>Fuel your body like a superhero! Stay hydrated and eat a balanced diet
									 to power through your day and conquer any challenge.</p>
							</section>
						</div>
					</div>
				</div>

			<!-- Promo -->
				<div id="promo-wrapper">
					<section id="promo">
						<h2>Emotional Self-Care
						</h2>
					</section>
				</div>

			<!-- Features 2 -->

				<div class="wrapper">
					<div class="container">
						<div class="row">
							<section class="col-6 col-12-narrower feature">
								<div class="image-wrapper first">
									<a href="#" class="image featured first"><img src="Img/pic06.jpg" alt="" /></a>
								</div>
								<header>
									<h2>Journal your thoughts or emotions.
									</h2>
								</header>
								<p>Journaling can help you process your emotions, identify patterns in your thoughts,
									 and develop a greater sense of self-awareness. </p>
							
							</section>
							<section class="col-6 col-12-narrower feature">
								<div class="image-wrapper">
									<a href="#" class="image featured"><img src="Img/pic07.jpg" alt="" /></a>
								</div>
								<header>
									<h2>Talk to a friend<br />
										or loved one about your feelings.</h2>
								</header>
								<p>Connecting with a friend or loved one and expressing your emotions can provide emotional support and validation. 
									It can also help you to feel less alone and more understood. </p>
							</section>
						</div>
					</div>
				</div>
			<!-- Promo -->
			<div id="promo-wrapper">
				<section id="promo">
					<h2>Mental and Spiritual Self-Care
					</h2>
				</section>
			</div>
			<!-- Features 3 -->
				
			<div class="wrapper">
				<div class="container">
					<div class="row">
						<section class="col-6 col-12-narrower feature">
							<div class="image-wrapper first">
								<a href="#" class="image featured first"><img src="Img/pic08.jpg" alt="" /></a>
							</div>
							<header>
								<h2>Read a book<br />
									or learn something new.</h2>
							</header>
							<p>Reading a book or learning something new can stimulate your mind, reduce stress, 
								and provide you with a sense of accomplishment. </p>
						
						</section>
						<section class="col-6 col-12-narrower feature">
							<div class="image-wrapper">
								<a href="#" class="image featured"><img src="Img/pic09.jpg" alt="" /></a>
							</div>
							<header>
								<h2>Practice gratitude by writing down 
									<br />
									what you are thankful for.</h2>
							</header>
							<p>By consciously acknowledging the things you're grateful for,
								 you can cultivate a more positive outlook on life and reduce stress. </p>
						</section>
					</div>
				</div>
			
			<!-- Promo -->
			<div id="promo-wrapper">
				<section id="promo">
					<h2>Additional Resources
					</h2>
				</section>
			</div>
<!-- Features 4 -->
				
<div class="wrapper">
	<section class="container">
		
		<div class="row features">
			<section class="col-4 col-12-narrower feature">
				<div class="image-wrapper first">
					<a href="https://www.verywellmind.com/practice-5-minute-meditation-3144714" class="image featured" target="_blank"><img src="Img/pic03.jpg" alt="" /></a>
				</div>
				<p>5-Minute Meditation Techniques</p>
			</section>
			<section class="col-4 col-12-narrower feature">
				<div class="image-wrapper">
					<a href="https://health.clevelandclinic.org/how-to-start-a-self-care-routine" class="image featured"target="_blank"><img src="Img/pic04.jpg" alt="" /></a>
				</div>
				<p>How to Create a Self-Care Routine</p>
						</section>
			<section class="col-4 col-12-narrower feature">
				<div class="image-wrapper">
					<a href="https://www.helpguide.org/wellness/fitness/the-mental-health-benefits-of-exercise" class="image featured"target="_blank"><img src="Img/pic05.jpg" alt="" /></a>
				</div>
				<p>The Benefits of Physical Exercise for Mental Health</p>
			</section>
		</div>
		
		<!-- Footer -->
<footer>
        <p>&copy; 2024 Te Hauora o Te Hinengaro. All Rights Reserved.</p>
</footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	</body>
</html>