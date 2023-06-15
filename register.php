<?php
// Include the credentials file
require_once "credentials.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $lrn = $_POST["lrn"];
    $firstName = $_POST["first_name"];
    $middleInitial = $_POST["middle_initial"];
    $lastName = $_POST["last_name"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $birthday = $_POST["birthday"];
    $gradeLevel = $_POST["grade_level"];
    $strand = $_POST["strand"];
    $phoneNumber = $_POST["phone_number"];
    $email = $_POST["email"];
    $dateEnrolled = date("Y-m-d"); // Automatically obtain the current date
    $password = $_POST["password"];

    // Perform database insertion (assuming you're using MySQLi)

    // Create a new MySQLi connection
    $conn = new mysqli("localhost", "root", "", "dbstudentdirectory");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement
    $sql = "INSERT INTO tblstudents (LRN, FirstName, MiddleInitial, LastName, Age, Gender, Birthday, GradeLevel, Strand, PhoneNumber, email, DateEnrolled, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "isssissssssss",
        $lrn,
        $firstName,
        $middleInitial,
        $lastName,
        $age,
        $gender,
        $birthday,
        $gradeLevel,
        $strand,
        $phoneNumber,
        $email,
        $dateEnrolled,
        $password
    );

    // Execute the statement
    if ($stmt->execute()) {
        // Registration successful
        echo "Registration successful!";
    } else {
        // Registration failed
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
