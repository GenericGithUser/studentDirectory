<?php
session_start();

// Include Server Connection Function
include 'credentials.php';

// Create a new PDO instance
try {
  $pdo = connect();
  // Set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Check if the form has been submitted
  if (isset($_POST['submit'])) {
    // Retrieve data from form
    $email = htmlspecialchars($_POST["email"], ENT_QUOTES);
    $lrnOrPassword = htmlspecialchars($_POST["lrn_password"], ENT_QUOTES);

    // Execute SQL query to retrieve data from the database
    $sql = "SELECT * FROM tblstudents WHERE (email = :email) OR (LRN = :lrn)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':lrn', $lrnOrPassword);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if user exists
    if ($user) {
      // Check if the user's password is NULL or the entered password matches
      if ($user['password'] === NULL || password_verify($lrnOrPassword, $user['password'])) {
        // Store user information in session
        $_SESSION['user_id'] = $user['LRN'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['FirstName'];

        // Check if the user's password has been set
        if ($user['password'] === NULL && $user['LRN'] === $lrnOrPassword) {
          // Redirect to password_update.php for the first-time login
          header("Location: password_update.php?first_login=true");
          exit;
        } else {
          // Redirect to dashboard.php or any other page after successful login
          header("Location: stuPage.php");
          exit;
        }
      } else {
        // Redirect to error.php if the password is not NULL and doesn't match
        header("Location: error.php");
        exit;
      }
    } else {
      // Redirect to error.php if email/LRN is invalid
      header("Location: error.php");
      exit;
    }
  }
} catch (PDOException $e) {
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
  <title>Login</title>
</head>
<body>
  <form action="login.php" method="POST">
    <h1>Login</h1>
    <div class="internalFormWrapper">
      <p>
        <input type="email" id="email" name="email" required placeholder="Email">
      </p>
      <p>
        <input type="text" id="lrn_password" name="lrn_password" required placeholder="LRN or Password">
      </p>
    </div>
    <p>
      <button type="submit" name="submit">Login</button>
    </p>
  </form>
</body>
</html>
