<?php
session_start();
// Include Connection Function
include 'credentials.php';
include './redirect.php';
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login.php
    header("Location: login.php");
    exit;
  }
  $LRN = $_GET['LRN'];
  try{
    $pdo = connect();
    // Set the PDO error mode to exception
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $LRN = null; 
        if(isset($_GET['LRN'])){
            $LRN = $_GET['LRN'];
            $viewDetails = "SELECT * FROM tblstudents WHERE LRN= :LRN";
            $stmt = $pdo->prepare($viewDetails);
            $stmt->bindParam(':LRN', $LRN);
            $stmt->execute();
            $select = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        }catch(PDOException $e) {
    // Display an error message if unable to connect to the database
    echo "Connection failed: " . $e->getMessage();
  }
  $pdo = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style3.css">
    <title>Sample Student Data</title>
</head>
<body>
    <div class="navbar">
        <img src="img/logo.png" alt="imgmissing">
        <h3>San Francisco High School Student's Directory</h3>
        <p><a href="<?php if(isset($_SESSION['student'])){echo'stuPage.php';}else{echo 'page.php';}?>"><img src="img/logout.png" class="logout">Go Back?</a></p>
    </div>
    <div class="content">
        <div class="profile">
            <div class="img">
                <img src="img/logo.png" alt="missing">
            </div>
            <div class="selections">
                <div class="option opt1 active" onclick="switcherii()">General Info</div>
                <div class="option opt2" onclick="switcheri()">Grades</div>
            </div>
        </div>
        <div class="contents">
        <!--Dialog for edit option-->
        <dialog class="edit" >
                 <h2>Edit Details</h2>
                 <form action="" method="POST" class="edit-form">
                    <div class="FCont">
                    <label for="LRN">Learner's Reference Number</label>
                    <input type="number" id="LRN" name="LRN" class="aSB_inpbx" maxlength="13">
                </div>
                <div class="FCont">
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname" class="aSB_inpbx" required>
                </div>
                <div class="FCont">
                    <label for="mname">Middle Name</label>
                    <input type="text" id="mname" name="mname" class="aSB_inpbx" maxlength="10" required>
                </div>
                <div class="FCont">
                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lname" class="aSB_inpbx" required>
                </div>
                <div class="FCont">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" class="aSB_inpbx" style="width:80px" maxlength="10" min="1" required>
                    <label for="gender" style="width:100px">Gender</label>
                    <select name="gender" id="gender" class="selectOption" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="FCont">
                    <label for="Birthday">Date of Birth</label>
                    <input type="date" name="Birthday" id="Birthday" required>
                </div>
                <div class="FCont">
                    <label for="GrdLvl" style="width:260px">Grade to be enrolled</label>
                    <select name="GrdLvl" id="GrdLvl" class="selectOption" required>
                            <option value="none">Select A Grade</option>
                            <option value="7">Grade 7</option>
                            <option value="8">Grade 8</option>
                            <option value="9">Grade 9</option>
                            <option value="10">Grade 10</option>
                            <option value="11">Grade 11</option>
                            <option value="12">Grade 12</option>
                        </select>
                </div>
                <div class="FCont">
                    <label for="strand">Strand</label>
                    <select name="strand" id="strand" class="selectOption" required>
                    <option value="JHS">JHS</option>
                        <option value="STEM">STEM</option>
                        <option value="ABM">ABM</option>
                        <option value="GAS">GAS</option>
                        <option value="TVL">TVL</option>
                    </select>
                    <label for="pNumber">Phone Number</label>
                    <input type="number" name="pNumber" id="pNumber" style="width:200px" maxlength="12" class="aSB_inpbx">
                </div>
                <div class="FCont">
                    <button onclick="closeEdit()" class="aSB_btn">Submit</button>
                </div>
                 </form>
                </dialog>
                <!--Dialog for confirmation of Deletion-->
                <dialog class="delete-confirm">
                    <form action="mockUserdata.php?LRN=<?php echo $LRN ?>" method="post">
                        <h2>Are you sure you want to delete this student?</h2>
                        <input type="submit" value="YES" name="submit" class="deleteBtn btn">
                        <button type="button" onclick="cancDel()" class="modifyBtn btn">NO</button>
                    </form>            
                </dialog>
                <?php
                //Delete PHP
                $pdo = connect();
                    if(isset($_POST['submit'])){
                        $sqlDelFor = "DELETE FROM tblgrades WHERE LRN= :LRN";
                        $delstmt = $pdo->prepare($sqlDelFor);
                        $delstmt->bindParam(':LRN', $LRN);
                        $delstmt->execute();
                        $sqlDelStu = "DELETE FROM tblstudents WHERE LRN=:LRN";
                        $delstmtMain = $pdo->prepare($sqlDelStu);
                        $delstmtMain->bindParam(':LRN', $LRN);
                        $delstmtMain->execute();
                        redirect();
                        exit;
                    }
                ?>
            <div class="genInfo">
                <div class="head">
                    <h1>General Information</h1>
                        <div class="opt"<?php if(isset($_SESSION['student'])){echo "style='display:none;'";}?>>
                            <div class="modifyBtn btn" onclick="showEdit()">Modify</div>
                            <div class="deleteBtn btn" onclick="openDel()">DELETE</div>
                           
                        </div>
                </div>
                <!--PHP loop for displaying data-->
                <?php foreach($select as $result){?>
                <div class="info">
                    <h2>Learner's Reference Number: <span class="name"><?php echo $result['LRN']; ?></span></h2>
                    <h2>Name:<span class="name"><?php echo $result['FirstName']. " ".$result['MiddleIntial']. " ".$result['LastName']; ?></span></h2>
                    <h2>Age:<span class="name"><?php echo $result['Age'];?></span></h2>
                    <h2>Gender:<span class="name"><?php echo $result['Gender'];?></span></h2>
                    <h2>Birthday:<span class="name"><?php echo date('F d,Y',strtotime($result['Birthday']));?></span></h2>
                    <h2>Grade Level:<span class="name"><?php echo $result['GradeLevel'];?></span></h2>
                    <h2>Strand:<span class="name"><?php echo $result['Strand'];?></span></h2>
                    <h2>Date Enrolled:<span class="name"><?php echo date('F d,Y',strtotime($result['DateEnrolled']));?></span></h2>
                    <h2>Phone Number:<span class="name"><?php echo $result['PhoneNumber'];?></span></h2>
                    <h2>Email:<span class="name"><?php echo $result['email'];?></span></h2>
                    
                </div>
                <?php }?>
                
            </div>
            <div class="grades">
                <div class="head">
                    <h1>Student's Grades</h1>
                    <div class="opt" <?php if(isset($_SESSION['student'])){echo "style='display:none;'";}?>>
                            <div class="modifyBtn btn">Modify</div>
                        </div>
                </div>
                <!--VERY BIG SPAGHETTI CODE FOR TABLE DOWN BELOW-->
                <?php
                //PHP for showing grades
                 try{
                    $pdo = connect();
                    // Set the PDO error mode to exception
                     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $LRN = null; 
                        if(isset($_GET['LRN'])){
                            $LRN = $_GET['LRN'];
                            $viewGrades = "SELECT * FROM tblgrades WHERE LRN= :LRN";
                            $stmt = $pdo->prepare($viewGrades);
                            $stmt->bindParam(':LRN', $LRN);
                            $stmt->execute();
                            $grSel = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        }
                        
                        }catch(PDOException $e) {
                    // Display an error message if unable to connect to the database
                    echo "Connection failed: " . $e->getMessage();
                  }
                  $pdo = null;
                ?>
                <?php foreach ($grSel as $grShow){ ?>
                <div class="gradeBox">
                    <div class="firstGrd box">
                        <div class="header">First Grading Grade</div>
                        <div class="sub1">First</div>
                        <div class="sub2">Second</div>
                        <div class="sub3">Thrid</div>
                        <div class="sub4">Fourth</div>
                        <div class="sub5">Fifth</div>
                        <div class="sub6">Sixth</div>
                        <div class="gr1st"><?php echo $grShow['FirstGradingGradeSub1'] ?></div>
                        <div class="gr1st-2"><?php echo $grShow['FirstGradingGradeSub2'] ?></div>
                        <div class="gr1st-3"><?php echo $grShow['FirstGradingGradeSub3'] ?></div>
                        <div class="gr1st-4"><?php echo $grShow['FirstGradingGradeSub4'] ?></div>
                        <div class="gr1st-5"><?php echo $grShow['FirstGradingGradeSub5'] ?></div>
                        <div class="gr1st-6"><?php echo $grShow['FirstGradingGradeSub6'] ?></div>
                    </div>
                    <div class="secGrd box">
                        <div class="header">Second Grading Grade</div>
                        <div class="sub1">First</div>
                        <div class="sub2">Second</div>
                        <div class="sub3">Thrid</div>
                        <div class="sub4">Fourth</div>
                        <div class="sub5">Fifth</div>
                        <div class="sub6">Sixth</div>
                        <div class="gr1st"><?php echo $grShow['SecondGradingGradeSub1'] ?></div>
                        <div class="gr1st-2"><?php echo $grShow['SecondGradingGradeSub2'] ?></div>
                        <div class="gr1st-3"><?php echo $grShow['SecondGradingGradeSub3'] ?></div>
                        <div class="gr1st-4"><?php echo $grShow['SecondGradingGradeSub4'] ?></div>
                        <div class="gr1st-5"><?php echo $grShow['SecondGradingGradeSub5'] ?></div>
                        <div class="gr1st-6"><?php echo $grShow['SecondGradingGradeSub6'] ?></div>
                    </div>
                    <div class="thrGrd box">
                        <div class="header">Third Grading Grade</div>
                        <div class="sub1">First</div>
                        <div class="sub2">Second</div>
                        <div class="sub3">Thrid</div>
                        <div class="sub4">Fourth</div>
                        <div class="sub5">Fifth</div>
                        <div class="sub6">Sixth</div>
                        <div class="gr1st"><?php echo $grShow['ThirdGradingGradeSub1'] ?></div>
                        <div class="gr1st-2"><?php echo $grShow['ThirdGradingGradeSub2'] ?></div>
                        <div class="gr1st-3"><?php echo $grShow['ThirdGradingGradeSub3'] ?></div>
                        <div class="gr1st-4"><?php echo $grShow['ThirdGradingGradeSub4'] ?></div>
                        <div class="gr1st-5"><?php echo $grShow['ThirdGradingGradeSub5'] ?></div>
                        <div class="gr1st-6"><?php echo $grShow['ThirdGradingGradeSub6'] ?></div>
                    </div>
                    <div class="fourGrd box">
                        <div class="header">Fourth Grading Grade</div>
                        <div class="sub1">First</div>
                        <div class="sub2">Second</div>
                        <div class="sub3">Thrid</div>
                        <div class="sub4">Fourth</div>
                        <div class="sub5">Fifth</div>
                        <div class="sub6">Sixth</div>
                        <div class="gr1st"><?php echo $grShow['ForuthGradingGradeSub1'] ?></div>
                        <div class="gr1st-2"><?php echo $grShow['ForuthGradingGradeSub2'] ?></div>
                        <div class="gr1st-3"><?php echo $grShow['ForuthGradingGradeSub3'] ?></div>
                        <div class="gr1st-4"><?php echo $grShow['ForuthGradingGradeSub4'] ?></div>
                        <div class="gr1st-5"><?php echo $grShow['ForuthGradingGradeSub5'] ?></div>
                        <div class="gr1st-6"><?php echo $grShow['ForuthGradingGradeSub6'] ?></div>
                    </div>
                </div>
                <?php }?>
            </div>
            
        </div>
    </div>
</body>
<script src="./scriptspage.js"></script>
</html>