<?php
// Include Server Connection Function
include 'credentials.php';

// Create a new PDO instance
try {
  $pdo = connect();
  // Set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_POST['submit'])){
        $LRN = $_POST['LRN'];
        $fname = $_POST['fname'];
        $mname = substr($_POST['mname'],0,1);
        $lname = $_POST['lname'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $Birthday = $_POST['Birthday'];
        $GrdLvl = $_POST['GrdLvl'];
        $strand = $_POST['strand'];
        $denrolld = date("Y-m-d");
        $pNumber = $_POST['pNumber'];
       
        
        $insert = "INSERT INTO tblstudents (LRN, FirstName, MiddleInital, LastName, Age, Gender, Birthday, GradeLevel, Strand, DateEnrolled, PhoneNumber)
        VALUES (:LRN, :fname, :mname, :lname, :age, :gender, :Birthday, :GrdLvl, :strand, :denrolld, :pNumber)" ;
        $stmt = $pdo->prepare($insert);
        $stmt->bindParam(':LRN', $LRN);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':mname', $mname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':Birthday', $Birthday);
        $stmt->bindParam(':GrdLvl', $GrdLvl);
        $stmt->bindParam(':strand', $strand);
        $stmt->bindParam(':denrolld', $denrolld);
        $stmt->bindParam(':pNumber', $pNumber);
        $stmnt->execute();
        echo $LRN;
        header("Location: page.php");
        exit;
        
    }



}catch (PDOException $e) {
  // Display an error message if unable to connect to the database
  echo "Connection failed: " . $e->getMessage();
}

// Close the Connection
$pdo = null;
?>



