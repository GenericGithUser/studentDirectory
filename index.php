<!DOCTYPE HTML>

<?php
session_start();
// Include Connection Function
include 'credentials.php';


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
	// Redirect to login.php
	header("Location: login.php");
	exit;
}

$lrn = "";
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
    $LRN = $_SESSION['user_id'];
}
?>
<html>

<head>
	<title>San Francisco High School</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/css/main.css" />
	<noscript>
		<link rel="stylesheet" href="assets/css/noscript.css" />
	</noscript>
</head>

<body class="is-preload">


	<!-- Page Wrapper -->
	<div id="page-wrapper">

		<!-- Header -->
		<header id="header" class="alt">
			<h1><a href="index.html">SFHS Student Portal</a></h1>
			<nav>
				<a href="#menu">Menu</a>
			</nav>
		</header>

		<nav id="menu">
			<div class="inner">
				<h2>Menu</h2>
				<ul class="links">
					<li><a href="index.php">Home</a></li>
					<li><a href="about.php">About</a></li>
					<?php
					 if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true) {
							echo '<li><a href="page.php">ADMIN DASHBOARD</a></li>';
						} else {
							echo '<li><a href="studentData.php?LRN=' . urlencode($LRN) . '">View Profile</a></li>';
						}
				
					?>

					<?php
					if (isset($_SESSION['user_id'])) {
						// User is logged in, show logout option
						echo '<li><a href="logout.php">Logout</a></li>';
					} else {
						// User is not logged in, show login option
						echo '<li><a href="login.php">Log In</a></li>';
					}
					?>

				</ul>
				<a href="#" class="close">Close</a>
			</div>
		</nav>

		<!-- Banner -->
		<section id="banner">
			<div class="inner">
				<div class="logo"><img src="img/logo.png" style="width:150px;"></div>
				<h2>Welcome To The SFHS Student Portal</h2>
				<p>To get started click <a href="login.php">here</a></p>
			</div>
		</section>

		<!-- Wrapper -->
		<section id="wrapper">

			<!-- One -->
			<section id="one" class="wrapper spotlight style1">
				<div class="inner">
					<a href="#" class="image"><img src="img/SAM_5296 Cropped.jpg" alt="" /></a>
					<div class="content">
						<h2 class="major"></h2>
						<p>With meticulously maintained facilities, we provide an ideal environment for learning and growth. Our comprehensive curriculum empowers students with diverse interests, offering a wide array of subjects like Foreign language classes, Programming courses, And Much more. Discover a place that not only nurtures academic success but also embodies the beauty of its surroundings.</p>
						<a href="https://www.facebook.com/sfhs.directory.ssg" class="special">Learn more</a>
					</div>
				</div>
			</section>

			<!-- Two -->
			<section id="two" class="wrapper alt spotlight style2">
				<div class="inner">
					<a href="#" class="image"><img src="img/account.png" alt="" /></a>
					<div class="content">
						<h2 class="major">Student Portal</h2>
						<p>This website acts as a bridge between Students and their information, allowing them access, at any time, to their student information which includes their name, lrn, grades and etc. To be able to Access and take advantage of this website, Contact Us for enrollment using the link bellow</p>
						<a href="https://www.facebook.com/sfhs.directory.ssg" class="special">Learn more</a>
					</div>
				</div>
			</section>

			<!-- Three -->
			<section id="three" class="wrapper spotlight style3">
				<div class="inner">
					<a href="#" class="image"><img src="images/pic03.jpg" alt="" /></a>
					<div class="content">
						<h2 class="major">Nullam dignissim</h2>
						<p>Lorem ipsum dolor sit amet, etiam lorem adipiscing elit. Cras turpis ante, nullam sit amet turpis non, sollicitudin posuere urna. Mauris id tellus arcu. Nunc vehicula id nulla dignissim dapibus. Nullam ultrices, neque et faucibus viverra, ex nulla cursus.</p>
						<a href="#" class="special">Learn more</a>
					</div>
				</div>
			</section>

			<!-- Four -->
			<section id="four" class="wrapper alt style1">
				<div class="inner">
					<h2 class="major">Vitae phasellus</h2>
					<p>Cras mattis ante fermentum, malesuada neque vitae, eleifend erat. Phasellus non pulvinar erat. Fusce tincidunt, nisl eget mattis egestas, purus ipsum consequat orci, sit amet lobortis lorem lacus in tellus. Sed ac elementum arcu. Quisque placerat auctor laoreet.</p>
					<section class="features">
						<article>
							<a href="#" class="image"><img src="images/pic04.jpg" alt="" /></a>
							<h3 class="major">Sed feugiat lorem</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing vehicula id nulla dignissim dapibus ultrices.</p>
							<a href="#" class="special">Learn more</a>
						</article>
						<article>
							<a href="#" class="image"><img src="images/pic05.jpg" alt="" /></a>
							<h3 class="major">Nisl placerat</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing vehicula id nulla dignissim dapibus ultrices.</p>
							<a href="#" class="special">Learn more</a>
						</article>
						<article>
							<a href="#" class="image"><img src="images/pic06.jpg" alt="" /></a>
							<h3 class="major">Ante fermentum</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing vehicula id nulla dignissim dapibus ultrices.</p>
							<a href="#" class="special">Learn more</a>
						</article>
						<article>
							<a href="#" class="image"><img src="images/pic07.jpg" alt="" /></a>
							<h3 class="major">Fusce consequat</h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing vehicula id nulla dignissim dapibus ultrices.</p>
							<a href="#" class="special">Learn more</a>
						</article>
					</section>

				</div>
			</section>

		</section>

		<!-- Scripts -->
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/jquery.scrollex.min.js"></script>
		<script src="assets/js/browser.min.js"></script>
		<script src="assets/js/breakpoints.min.js"></script>
		<script src="assets/js/util.js"></script>
		<script src="assets/js/main.js"></script>

</body>

</html>