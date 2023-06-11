<?php
// Include Server Connection Function
include 'credentials.php';

// Create a new PDO instance
try {
  $pdo = connect();
  // Set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Check if the form has been submitted
  if(isset($_POST['submit'])) {
    // Sanitize data from form
    $lrn = htmlspecialchars($_POST["lrn"], ENT_QUOTES);
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = htmlspecialchars($_POST["password"], ENT_QUOTES);

    // Hash the password before storing it in the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Execute SQL query to insert data into database
    $sql = "INSERT INTO tblstudents (LRN, email, password) VALUES (:lrn, :email, :password)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':lrn', $lrn);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->execute();

    // Redirect to login.php with success message
    header("Location: login.php?success=true");
    exit;
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
  <title>Register</title>
</head>
<body>
  <form action="register.php" method="POST">
    <h1>Register</h1>
    <div class="internalFormWrapper">
      <p>
        <input type="text" id="lrn" name="lrn" required placeholder="LRN">
      </p>
      <p>
        <input type="email" id="email" name="email" required placeholder="Email">
      </p>
      <p>
        <input type="password" id="password" name="password" required placeholder="Password">
      </p>
    </div>
    <p>
      <button type="submit" name="submit">Create User</button>
    </p>
  </form>
</body>
</html>
