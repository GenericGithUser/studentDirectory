<?php
// Database connection parameters
$dbname = "dbstudentdirectory";
$username = "root";
$password = "";
$host = "localhost";

// Create a new PDO instance
try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  // Set the PDO error mode to exception
} catch (PDOException $e) {
  // Display an error message if unable to connect to the database
  echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  <link rel="stylesheet" href="style.css">
  <title> Register</title> 
</head>

<body>
  
  <form action="create.php" method="POST">
  <h1>Register</h1>
    <div class="internalFormWrapper">
      <p>
    
        <input type="text" id="name" name="name" required placeholder="Username">
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