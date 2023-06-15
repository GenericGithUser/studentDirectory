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


		<!-- Four -->
		<section id="four" class="wrapper alt style1">
			<div class="inner">
				<h2 class="major">Contributors</h2>
				<p> The people who spent countless hours developing this project from the pure conceptualization into a production ready product.</p>
				<section class="features">
					<article>
						<a href="#" class="image"><img src="img/gian.png" alt="" /></a>
						<h3 class="major">Abril, Gianmarlo Adrian S.</h3>
						<p> Lead developer & Management Head</p>
						<a href="https://github.com/GenericGithUser" class="special">Learn more</a>
					</article>
					<article>
						<a href="#" class="image"><img src="img/juls.jpg" alt="" /></a>
						<h3 class="major">Castillejo, Julius Henrich E.</h3>
						<p>Lead Developer & Head of Page Design</p>
						<a href="https://github.com/2Tsk2" class="special">Learn more</a>
					</article>
					<article>
						<a href="#" class="image"><img src="img/rey.jpg" alt="" /></a>
						<h3 class="major">Lastimado, Reynally Mae G.</h3>
						<p>Head of material design</p>

					</article>
					<article>
						<h3 class="major">

							Aj Parado <br>
							Andrei Glifonea Vidal<br>
							Christine Salmingo Tayag<br>
							Gerard Monsanto<br>
							Melan Justine<br>
							Reynally Mae Lastimado<br>
							Ronalyn Ramos<br></h3>
						<p>Moral support</p>

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