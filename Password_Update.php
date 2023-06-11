<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  // Redirect to login.php if not logged in
  header("Location: login.php");
  exit;
}

// Include Server Connection Function
include 'credentials.php';

// Create a new PDO instance
try {
  $pdo = connect();
  // Set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Check if the form has been submitted
  if(isset($_POST['submit'])) {
    // Retrieve data from form
    $new_password = htmlspecialchars($_POST["new_password"], ENT_QUOTES);
    $confirm_password = htmlspecialchars($_POST["confirm_password"], ENT_QUOTES);

    // Check if the new password and confirm password match
    if ($new_password === $confirm_password) {
      // Hash the new password
      $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

      // Update the password in the database
      $sql = "UPDATE tblstudents SET password = :password WHERE LRN = :lrn";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':password', $hashed_password);
      $stmt->bindParam(':lrn', $_SESSION['user_id']);
      $stmt->execute();

      // Redirect to dashboard.php or any other page after successful password update
      header("Location: stuPage.php");
      exit;
    } else {
      // Redirect to password_update.php with error message
      header("Location: password_update.php?error=true");
      exit;
    }
  }
} catch(PDOException $e) {
  // Display an error message if unable to connect to the database
  echo "Connection failed: " . $e->getMessage();
}

// Close the database connection
$pdo = null;
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
  <title>Update Password</title>
</head>
<body>
  <form action="password_update.php" method="POST">
    <h1>Update Password</h1>
    <div class="internalFormWrapper">
      <p>
        <input type="password" id="new_password" name="new_password" required placeholder="New Password">
      </p>
      <p>
        <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm Password">
      </p>
    </div>
    <p>
      <button type="submit" name="submit">Update Password</button>
    </p>
  </form>
</body>
</html>
