<?php
require_once('credentials.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $lrn = $_POST['lrn'];
    $firstName = $_POST['firstName'];
    $middleInitial = $_POST['middleInitial'];
    $lastName = $_POST['lastName'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $gradeLevel = $_POST['gradeLevel'];
    $strand = $_POST['strand'];
    $phoneNumber = $_POST['phoneNumber'];
    $email = $_POST['email'];
    $dateEnrolled = date('Y-m-d');
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO tblstudents (LRN, FirstName, MiddleInitial, LastName, Age, Gender, Birthday, GradeLevel, Strand, PhoneNumber, email, DateEnrolled, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssissssssss", $lrn, $firstName, $middleInitial, $lastName, $age, $gender, $birthday, $gradeLevel, $strand, $phoneNumber, $email, $dateEnrolled, $password);
    
    if ($stmt->execute()) {
        // Redirect to success page
        header("Location: success.php");
        exit();
    } else {
        // Display error message
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="align">
        <div class="grid">
            <form class="form login" method="POST" action="">
                <div class="form__field">
                    <label class="hidden">LRN</label>
                    <input type="text" name="lrn" class="form__input" placeholder="LRN" required>
                </div>
                <div class="form__field">
                    <label class="hidden">First Name</label>
                    <input type="text" name="firstName" class="form__input" placeholder="First Name" required>
                </div>
                <div class="form__field">
                    <label class="hidden">Middle Initial</label>
                    <input type="text" name="middleInitial" class="form__input" placeholder="Middle Initial" required>
                </div>
                <div class="form__field">
                    <label class="hidden">Last Name</label>
                    <input type="text" name="lastName" class="form__input" placeholder="Last Name" required>
                </div>
                <div class="form__field">
                    <label class="hidden">Age</label>
                    <input type="text" name="age" class="form__input" placeholder="Age" required>
                </div>
                <div class="form__field">
                    <label class="hidden">Gender</label>
                    <input type="text" name="gender" class="form__input" placeholder="Gender" required>
                </div>
                <div class="form__field">
                    <label class="hidden">Birthday</label>
                    <input type="text" name="birthday" class="form__input" placeholder="Birthday" required>
                </div>
                <div class="form__field">
                    <label class="hidden">Grade Level</label>
                    <input type="text" name="gradeLevel" class="form__input" placeholder="Grade Level" required>
                </div>
                <div class="form__field">
                    <label class="hidden">Strand</label>
                    <input type="text" name="strand" class="form__input" placeholder="Strand" required>
                </div>
                <div class="form__field">
                    <label class="hidden">Phone Number</label>
                    <input type="text" name="phoneNumber" class="form__input" placeholder="Phone Number" required>
                </div>
                <div class="form__field">
                    <label class="hidden">Email</label>
                    <input type="email" name="email" class="form__input" placeholder="Email" required>
                </div>
                <div class="form__field">
                    <label class="hidden">Password</label>
                    <input type="password" name="password" class="form__input" placeholder="Password" required>
                </div>
                <input type="submit" value="Register">
            </form>
        </div>
    </div>
</body>

</html>
