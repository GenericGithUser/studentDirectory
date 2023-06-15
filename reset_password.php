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
        $newPassword = htmlspecialchars($_POST["new_password"], ENT_QUOTES);
        $confirmPassword = htmlspecialchars($_POST["confirm_password"], ENT_QUOTES);

        // Execute SQL query to retrieve data from the database for admins
        $sqlAdmin = "SELECT * FROM users WHERE email = :email AND UserType = 'admin'";
        $stmtAdmin = $pdo->prepare($sqlAdmin);
        $stmtAdmin->bindParam(':email', $email);
        $stmtAdmin->execute();
        $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

        // Execute SQL query to retrieve data from the database for students
        $sqlStudent = "SELECT * FROM tblstudents WHERE email = :email";
        $stmtStudent = $pdo->prepare($sqlStudent);
        $stmtStudent->bindParam(':email', $email);
        $stmtStudent->execute();
        $student = $stmtStudent->fetch(PDO::FETCH_ASSOC);

        // Check if admin user exists
        if ($admin) {
            // Check if the new password and confirm password match
            if ($newPassword === $confirmPassword) {
                // Update the admin's password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateSql = "UPDATE users SET password = :password WHERE id = :id";
                $updateStmt = $pdo->prepare($updateSql);
                $updateStmt->bindParam(':password', $hashedPassword);
                $updateStmt->bindParam(':id', $admin['id']);
                $updateStmt->execute();

                // Redirect to a success page
                header("Location: login.php");
                exit;
            } else {
                // Redirect to an error page if the passwords don't match
                header("Location: password_reset_error.php");
                exit;
            }
        }

        // Check if student user exists
        elseif ($student) {
            // Check if the new password and confirm password match
            if ($newPassword === $confirmPassword) {
                // Update the student's password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateSql = "UPDATE tblstudents SET password = :password WHERE email = :email";
                $updateStmt = $pdo->prepare($updateSql);
                $updateStmt->bindParam(':password', $hashedPassword);
                $updateStmt->bindParam(':email', $email);
                $updateStmt->execute();

                // Redirect to a success page
                header("Location: login.php");
                exit;
            } else {
                // Redirect to an error page if the passwords don't match
                header("Location: password_reset_error.php");
                exit;
            }
        } else {
            // Redirect to an error page if email is invalid or not found in the database
            header("Location: password_reset_error.php");
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="style.css">
    <title>Password Reset</title>
</head>
<body>
<div class="container">
    <div class="sign-up-form">
        <!-- Left (Form Image) -->
        <div class="form-image">
            <img src="./assets/form-bg.png" alt="">
        </div>
        <!-- Right (Form Content) -->
        <form class="form-content" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Form Heading -->
            <div class="form-heading">
                <img src="img/logo.png" alt="">
                <h1>Forgot Password</h1>
                <p>Please enter your email and new password to reset your password!</p>
            </div>
            <!-- Input Wrap -->
            <div class="input-wrap">
                <div class="input">
                    <input type="email" name="email" id="email" placeholder=" ">
                    <div class="label">
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="input">
                    <input type="password" name="new_password" id="new_password" placeholder=" ">
                    <div class="label">
                        <label for="new_password">New Password</label>
                    </div>
                </div>
                <div class="input">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder=" ">
                    <div class="label">
                        <label for="confirm_password">Confirm Password</label>
                    </div>
                </div>
            </div>
            <button type="submit" name="submit">Reset Password</button>
        </form>
    </div>
</div>
</body>
</html>
