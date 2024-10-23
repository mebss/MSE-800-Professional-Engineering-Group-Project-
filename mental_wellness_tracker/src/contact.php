<?php
session_start();
?>

<!DOCTYPE HTML>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
		<title>Contact Us - Te Hauora o Te Hinengaro</title>

		<link rel="stylesheet" href="assets/css/main.css" />
		 <!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    	<!-- Custom CSS -->
    	<link rel="stylesheet" href="style.css">
	</head>
	
	<body class="is-preload">
		<!-- Include the Navbar -->
		<?php include 'navbar.php'; ?>

		<div id="page-wrapper">
					
			<!-- Banner -->
				<section id="banner">
					<header>

					</header>
				</section>
			<!-- Gigantic Heading -->
				<section class="wrapper style2">
					<div class="container">
						<header class="major">
							<h5>Here are some key mental health services 
								and support lines in New Zealand:
							</h5>
						</header>
					</div>
				</section>
				<!-- Posts -->
				<section class="wrapper style1">
					<div class="container">
						<div class="row">
							<section class="col-6 col-12-narrower">
								<div class="box post">
									<a href="https://1737.org.nz/" target="_blank" class="image left"><img src="Img\house.jpg" alt="" /></a>
									<div class="inner">
										<h3><strong>1737 – Need to Talk?</strong>
										</h3>
										<p>Call or text <strong>1737</strong> to talk to a trained counsellor 24/7.
										</p>
									</div>
								</div>
							</section>
							<section class="col-6 col-12-narrower">
								<div class="box post">
									<a href="https://www.lifeline.org.nz/" target="_blank" class="image left"><img src="Img\lifeline.jpg" alt="" /></a>
									<div class="inner">
										<h3><strong>Lifeline</strong></h3>
										<p>Call <strong>0800 543 354</strong> or text <strong>4357</strong> for free, confidential support.</p>
									</div>
								</div>
							</section>
						</div>
						<div class="row">
							<section class="col-6 col-12-narrower">
								<div class="box post">
									<a href="https://www.lifeline.org.nz/services/suicide-crisis-helpline/" target="_blank" class="image left"><img src="Img\call-center.jpg" alt="" /></a>
									<div class="inner">
										<h3><strong>Suicide Crisis Helpline</strong></h3>
										<p>Call <strong>0508 828 865</strong> (0508 TAUTOKO) for help in a crisis.</p>
									</div>
								</div>
							</section>
							<section class="col-6 col-12-narrower">
								<div class="box post">
									<a href="https://www.youthline.co.nz/" target="_blank" class="image left"><img src="Img\youth.jpg" alt="" /></a>
									<div class="inner">
										<h3><strong>Youthline</strong></h3>
										<p>Call <strong>0800 376 633</strong> or text <strong>234</strong>.</p>
									</div>
								</div>
							</section>
						</div>
					</div>
				</section>
				<!-- Heading -->
				<section class="wrapper style2">
					<div class="container">
						<header class="major">
							<h5>Additional Mental Health Resources</h5>
						</header>
					</div>
				</section>
				<!-- Highlights -->
				<section class="wrapper style1">
					<div class="container">
						<div class="row gtr-200">
							<section class="col-4 col-12-narrower">
								<div class="box highlight">
									<a href="https://mentalhealth.org.nz/" target="_blank" class="hover-link">
										<i class="icon solid major fa-paper-plane"></i>
									</a>
									<h3><strong>Mental Health Foundation</strong></h3>
									<p>Provides information and support for mental wellbeing.</p>
								</div>
							</section>
							<section class="col-4 col-12-narrower">
								<div class="box highlight">
								<a href="https://anxiety.org.nz/" target="_blank" class="hover-link">
									<i class="icon solid major fa-pencil-alt"></i>
								</a>
									<h3><strong>Anxiety NZ</strong></h3>
									<p>Specialist support for anxiety-related issues.<br>
									Call <strong>0800 269 4389</strong>.</p>
								</div>
							</section>
							<section class="col-4 col-12-narrower">
								<div class="box highlight">
								<a href="https://www.samaritans.org.nz/" target="_blank" class="hover-link">
									<i class="icon solid major fa-wrench"></i>
								</a>
									<h3><strong>Samaritans NZ</strong></h3>
									<p>Call <strong>0800 726 666</strong> for confidential support.</p>
								</div>
							</section>
						</div>
					</div>
				</section>
			<!-- Display success or error messages after form submission -->
			<?php
					if (isset($_GET['success']) && $_GET['success'] == 1) {
						echo "<div class='alert alert-success mt-4'>Your message has been sent successfully!</div>";
					} elseif (isset($_GET['error']) && $_GET['error'] == 1) {
						echo "<div class='alert alert-danger mt-4'>There was an error sending your message. Please try again later.</div>";
					}
			?>
			<!-- Gigantic Heading -->
				<section class="wrapper style2">
					<div class="container">
						<header class="major">
							<h2>Get in Touch with US</h2>
						</header>
					</div>
				</section>
			<!-- Contact Us -->

					<div class="container">
						<div class="row">
							
							</section>
							<section class="col-6 col-12-narrower">
								<h3>Get In Touch</h3>
								<form method="POST" action="send_contact_form.php" class="mb-5">
									<div class="mb-3">
										<label for="name" class="form-label">Your Name</label>
										<input type="text" class="form-control" id="name" name="name" required>
									</div>
									<div class="mb-3">
										<label for="email" class="form-label">Your Email</label>
										<input type="email" class="form-control" id="email" name="email" required>
									</div>
									<div class="mb-3">
										<label for="message" class="form-label">Your Message</label>
										<textarea class="form-control" id="message" name="message" rows="4" required></textarea>
									</div>
									<button type="submit" class="btn btn-success">Send Message</button>
								</form>
							</section>
						</div>
					</div>

				
			

		</div>
		 <!-- Footer -->
		 <footer class="mt-auto">
        <p>&copy; 2024 Te Hauora o Te Hinengaro. All Rights Reserved.</p>
   		 </footer>				
		<!-- Scripts -->
			
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

	</body>
</html>