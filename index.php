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
						<h2 class="major">Why SFHS?</h2>
						<p>With meticulously maintained facilities, we provide an ideal environment for learning and growth. Our comprehensive curriculum empowers students with diverse interests, offering a wide array of subjects like Foreign language classes, Programming courses, And Much more. Discover a place that not only nurtures academic success but also embodies the beauty of its surroundings.</p>
						<a href="https://www.facebook.com/sfhs.directory.ssg" class="special">Learn more</a>
					</div>
				</div>
			</section>

			<!-- Two -->
			<section id="two" class="wrapper alt spotlight style2">
				<div class="inner">
					<a href="#" class="image"><img src="img/location_c.jpg" alt="" /></a>
					<div class="content">
						<h2 class="major">Where is San Francisco High School Located? and Brief History</h2>
						<p>It is situated in Misamis St., Brgy. Sto. Cristo, Bago Bantay, Quezon City. It started as an annex of Quzon City High School Until it became it's own school in 1958</p>
						<a href="#" class="special">Learn more</a>
					</div>
				</div>
			</section>

			<!-- Three -->
			<section id="three" class="wrapper spotlight style3">
				<div class="inner">
					<a href="#" class="image"><img src="img/hand_c.jpg" alt="" /></a>
					<div class="content">
						<h2 class="major">Programs Offered</h2>
						<p>The school offers many programs such as the STE a JHS version of STEM, the TVL course for Senior High, it focuses on Programming or Animation, and many more</p>
						<a href="#" class="special">Learn more</a>
					</div>
				</div>
			</section>

			<!-- Four -->
			<section id="four" class="wrapper alt style1">
				<div class="inner">
					<h2 class="major">Senior High School Academic Strands Offered</h2>
					<p>Cras mattis ante fermentum, malesuada neque vitae, eleifend erat. Phasellus non pulvinar erat. Fusce tincidunt, nisl eget mattis egestas, purus ipsum consequat orci, sit amet lobortis lorem lacus in tellus. Sed ac elementum arcu. Quisque placerat auctor laoreet.</p>
					<section class="features">
						<article>
							<a href="#" class="image"><img src="images/pic04.jpg" alt="" /></a>
							<h3 class="major">Science, Technology, Enginering, Mathematics</h3>
							<p>Science, Technology, Engineering, and Mathematics are intertwining disciplines when applied in the real world. The difference of the STEM curriculum with the other strands and tracks is the focus on advanced concepts and topics.</p>
							<a href="#" class="special">Learn more</a>
						</article>
						<article>
							<a href="#" class="image"><img src="images/pic05.jpg" alt="" /></a>
							<h3 class="major">Accounting, Business and Management</h3>
							<p>The Accountancy, Business and Management (ABM) strand would focus on the basic concepts of financial management, business management, corporate operations, and all things that are accounted for. ABM can also lead you to careers on management and accounting which could be sales manager, human resources, marketing director, project officer, bookkeeper, accounting clerk, internal auditor, and a lot more.</p>
							<a href="#" class="special">Learn more</a>
						</article>
						<article>
							<a href="#" class="image"><img src="images/pic06.jpg" alt="" /></a>
							<h3 class="major">Humanities And Social Sciences Strand</h3>
							<p>The HUMMS strand is designed for those who wonder what is on the other side of the wall. In other words, you are ready to take on the world and talk to a lot of people. This is for those who are considering taking up journalism, communication arts, liberal arts, education, and other social science-related courses in college.</p>
							<a href="#" class="special">Learn more</a>
						</article>
						<article>
							<a href="#" class="image"><img src="images/pic07.jpg" alt="" /></a>
							<h3 class="major">General Academic Strand</h3>
							<p>While the other strands are career-specific, the General Academic Strand is great for students who are still undecided on which track to take. You can choose electives from the different academic strands under this track.</p>
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