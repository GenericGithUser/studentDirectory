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
    if(isset($_POST['submit'])) {
      // Retrieve data from form
      $email = $_POST["email"];
      $password = $_POST["password"];

      // Execute SQL query to retrieve data from database
      $sql = "SELECT * FROM users WHERE email = :email";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':email', $email);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      // Verify password
      if ($user && password_verify($password, $user['password'])) {
        // Store user information in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name'];

        // Redirect to dashboard.php
        header("Location: dashboard.php");
        exit;
      } else {
        // Redirect to error.php
        header("Location: error.php");
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
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <form action="login.php" method="POST">
    <h1>SFHS Student Directory</h1>
      <div class="internalFormWrapper">
      <p>
        <label for="email"></label>
        <input type="email" id="email" name="email" required placeholder="Email">
      </p>
      <p>
        <label for="password"></label>
        <input type="password" id="password" name="password" required placeholder="password">
      </p>
  </div>
      <p class="chooseButtonWrapper">
        <button type="submit" name="submit">Login</button>
        <a href="register.php"><button  type="button"  >register</button></a>
      </p>
    </form>
  </body>
  </html>
