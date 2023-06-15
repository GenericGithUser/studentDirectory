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
        $email = htmlspecialchars($_POST["email"], ENT_QUOTES);
        $lrnOrPassword = htmlspecialchars($_POST["lrn_password"], ENT_QUOTES);

        // Execute SQL query to retrieve data from the database for admins
        $sqlAdmin = "SELECT * FROM users WHERE email = :email AND UserType = 'admin'";
        $stmtAdmin = $pdo->prepare($sqlAdmin);
        $stmtAdmin->bindParam(':email', $email);
        $stmtAdmin->execute();
        $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

        // Execute SQL query to retrieve data from the database for students
        $sqlStudent = "SELECT * FROM tblstudents WHERE (email = :email) OR (LRN = :lrn)";
        $stmtStudent = $pdo->prepare($sqlStudent);
        $stmtStudent->bindParam(':email', $email);
        $stmtStudent->bindParam(':lrn', $lrnOrPassword);
        $stmtStudent->execute();
        $student = $stmtStudent->fetch(PDO::FETCH_ASSOC);

        // Check if admin user exists
        if ($admin) {
            // Check if the admin's password is NULL or the entered password matches
            if ($admin['password'] === NULL || password_verify($lrnOrPassword, $admin['password'])) {
                // Store admin information in session
                $_SESSION['user_id'] = $admin['id'];
                $_SESSION['user_email'] = $admin['email'];
                $_SESSION['user_name'] = $admin['name'];
                $_SESSION['isAdmin'] = true; // Set isAdmin flag to true for admin user

                // Check if the admin's password has been set
                if ($admin['password'] === NULL && $admin['LRN'] === $lrnOrPassword) {
                    // Redirect to password_update.php for the first-time login
                    header("Location: password_update.php?first_login=true");
                    exit;
                } else {
                    // Redirect to dashboard.php or any other page after successful login
                    header("Location: page.php");
                    exit;
                }
            } else {
                // Redirect to error.php if the password is not NULL and doesn't match
                header("Location: error.php");
                exit;
            }
        }
        // Check if student user exists
        elseif ($student) {
            // Check if the student's password is NULL or the entered password matches
            if ($student['password'] === NULL || password_verify($lrnOrPassword, $student['password'])) {
                // Store student information in session
                $_SESSION['user_id'] = $student['LRN'];
                $_SESSION['user_email'] = $student['email'];
                $_SESSION['user_name'] = $student['name'];
                $_SESSION['isAdmin'] = false; // Set isAdmin flag to false for student user

                // Check if the student's password has been set
                if ($student['password'] === NULL && $student['LRN'] === $lrnOrPassword) {
                    // Redirect to password_update.php for the first-time login
                    header("Location: password_update.php?first_login=true");
                    exit;
                } else {
                    // Redirect to dashboard.php or any other page after successful login
                    header("Location: page.php");
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