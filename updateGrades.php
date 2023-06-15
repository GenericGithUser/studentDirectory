<?php
session_start();
include 'credentials.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login.php or appropriate location
    header("Location: login.php");
    exit;
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Retrieve the LRN from the URL parameter
        $LRN = $_GET['LRN'];

        // Prepare the UPDATE query
        $updateQuery = "UPDATE grades SET ";
        
        // Update each quarter's subject grades
        for ($quarter = 1; $quarter <= 4; $quarter++) {
            for ($subject = 1; $subject <= 8; $subject++) {
                $grade = $_POST["quarter{$quarter}_subject{$subject}"];
                
                // Append the column and value to the UPDATE query
                $updateQuery .= "Quarter{$quarter}_Subject{$subject} = :grade{$quarter}_{$subject}, ";
            }
        }
        
        // Remove the trailing comma and space from the query
        $updateQuery = rtrim($updateQuery, ", ");
        
        // Add the WHERE clause to update grades for the specific LRN
        $updateQuery .= " WHERE LRN = :LRN";

        // Prepare the UPDATE statement
        $updateStmt = $pdo->prepare($updateQuery);
        
        // Bind the values to the placeholders
        for ($quarter = 1; $quarter <= 4; $quarter++) {
            for ($subject = 1; $subject <= 8; $subject++) {
                $gradeParam = ":grade{$quarter}_{$subject}";
                $updateStmt->bindValue($gradeParam, $_POST["quarter{$quarter}_subject{$subject}"]);
            }
        }
        
        $updateStmt->bindParam(':LRN', $LRN);
        
        // Execute the UPDATE statement
        $updateStmt->execute();

        // Redirect to the grades page or appropriate location
        header("Location: studentData.php?LRN=" . urlencode($LRN));
        exit;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
?>
