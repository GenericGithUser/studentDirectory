<?php
session_start();

// Include Server Connection Function
include 'credentials.php';

// Create a new PDO instance
try {
    $pdo = connect();

    // Check if the form has been submitted
    if (isset($_POST['submit'])) {
        // Retrieve data from form
        $name = htmlspecialchars($_POST["name"], ENT_QUOTES);
        $email = htmlspecialchars($_POST["email"], ENT_QUOTES);
        $password = htmlspecialchars($_POST["password"], ENT_QUOTES);

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Execute SQL query to insert admin account into the users table
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        // Redirect to login.php after successful registration
        header("Location: login.php");
        exit;
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
    <title>Register</title>
</head>
<body>
<form action="register.php" method="POST">
    <h1>Register</h1>
    <div class="internalFormWrapper">
        <p>
            <input type="text" id="name" name="name" required placeholder="Name">
        </p>
        <p>
            <input type="email" id="email" name="email" required placeholder="Email">
        </p>
        <p>
            <input type="password" id="password" name="password" required placeholder="Password">
        </p>
    </div>
    <p>
        <button type="submit" name="submit">Register</button>
    </p>
</form>
</body>
</html>
