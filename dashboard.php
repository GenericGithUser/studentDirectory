<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  // Redirect to login.php
  header("Location: login.php");
  exit;
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
</head>

<body>
  <div class="textContainer">
    <h1>Dashboard</h1>
    <?php echo "Welcome, " . $_SESSION['user_name'] . "!"; ?>
    <?php
		$time = date('h:i:s A');
		echo "<p>The current time is: " . $time . "</p>";
	?>x
    <p>You are now logged in.</p>
    <a href="page.php">Go to Directory</a><!--Temp way to go with session? idk-->
    <a href="login.php">Logout</a>
  </div>
</body>

</html>