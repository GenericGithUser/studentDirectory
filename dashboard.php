<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  // Redirect to login.php
  header("Location: login.php");
  exit;
}

// Display user information
echo "Welcome, " . $_SESSION['user_email'] . "!";
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
  <h1>Dashboard</h1>
  <p>You are now logged in.</p>
  <a href="login.php">Logout</a>
</body>

</html>