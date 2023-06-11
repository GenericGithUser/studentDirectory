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
        <dialog class="edit">
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
                    <input type="submit" class="aSB_btn" value="Submit" name="submit">
                    <button type="button" onclick="closeEdit()" class="aSB_btn">Cancel</button>
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
                <!--Dialogs for modifying grades-->
                <dialog class="modGrades">    
                     <h2>Which grading would you like to modify?</h2>
                     <button type="button" onclick="openFirst()" class="btn">First Grading</button>
                     <button type="button" onclick="openSecond()" class="btn">Second Grading</button>               
                     <button type="button" onclick="openThird()" class="btn">Third Grading</button>
                     <button type="button" onclick="openFourth()" class="btn">Fourth Grading</button><br>
                     <button type="button" onclick="cancelMod()" class="btn">Cancel</button>
                        <dialog class="firstgrading grdChange">
                        <form action="mockUserdata.php?LRN=<?php echo $LRN; ?>" method="POST">
                            <label for="FirstGradingGradeSub1">Subject 1</label>
                            <input type="text" name="FirstGradingGradeSub1" id="FirstGradingGradeSub1" class="aSB_inpbx spec"><br>
                            <label for="FirstGradingGradeSub2">Subject 2</label>
                            <input type="text" name="FirstGradingGradeSub2" id="FirstGradingGradeSub2" class="aSB_inpbx spec"><br>
                            <label for="FirstGradingGradeSub3">Subject 3</label>
                            <input type="text" name="FirstGradingGradeSub3" id="FirstGradingGradeSub3" class="aSB_inpbx spec"><br>
                            <label for="FirstGradingGradeSub4">Subject 4</label>
                            <input type="text" name="FirstGradingGradeSub4" id="FirstGradingGradeSub4" class="aSB_inpbx spec"><br>
                            <label for="FirstGradingGradeSub5">Subject 5</label>
                            <input type="text" name="FirstGradingGradeSub5" id="FirstGradingGradeSub5" class="aSB_inpbx spec"><br>
                            <label for="FirstGradingGradeSub6">Subject 6</label>
                            <input type="text" name="FirstGradingGradeSub6" id="FirstGradingGradeSub6" class="aSB_inpbx spec"><br>
                            <input type="submit" value="Change" name="change" class="btn">
                            <button type="button" onclick="closeFirst()" class="btn">Cancel</button>
                            <input type="hidden" value="First" name="checker">
                            </form>
                        </dialog>
                        <dialog class="secgrading grdChange">
                        <form action="mockUserdata.php?LRN=<?php echo $LRN; ?>" method="POST">
                            <label for="SecondGradingGradeSub1">Subject 1</label>
                            <input type="text" name="SecondGradingGradeSub1" id="SecondGradingGradeSub1" class="aSB_inpbx spec"><br>
                            <label for="SecondGradingGradeSub2">Subject 2</label>
                            <input type="text" name="SecondGradingGradeSub2" id="SecondGradingGradeSub2" class="aSB_inpbx spec"><br>
                            <label for="SecondGradingGradeSub3">Subject 3</label>
                            <input type="text" name="SecondGradingGradeSub3" id="SecondGradingGradeSub3" class="aSB_inpbx spec"><br>
                            <label for="SecondGradingGradeSub4">Subject 4</label>
                            <input type="text" name="SecondGradingGradeSub4" id="SecondGradingGradeSub4" class="aSB_inpbx spec"><br>
                            <label for="SecondGradingGradeSub5">Subject 5</label>
                            <input type="text" name="SecondGradingGradeSub5" id="SecondGradingGradeSub5" class="aSB_inpbx spec"><br>
                            <label for="SecondGradingGradeSub6">Subject 6</label>
                            <input type="text" name="SecondGradingGradeSub6" id="SecondGradingGradeSub6" class="aSB_inpbx spec"><br>
                            <input type="submit" value="Change" name="change" class="btn">
                            <button type="button" onclick="closeSec()" class="btn">Cancel</button>
                            <input type="hidden" value="Second" name="checker">
                            </form>
                        </dialog>
                        <dialog class="thridgrading grdChange">
                        <form action="mockUserdata.php?LRN=<?php echo $LRN; ?>" method="POST">
                            <label for="ThridGradingGradeSub1">Subject 1</label>
                            <input type="text" name="ThirdGradingGradeSub1" id="ThirdGradingGradeSub1" class="aSB_inpbx spec"><br>
                            <label for="ThridGradingGradeSub2">Subject 2</label>
                            <input type="text" name="ThirdGradingGradeSub2" id="ThirdGradingGradeSub2" class="aSB_inpbx spec"><br>
                            <label for="ThridGradingGradeSub3">Subject 3</label>
                            <input type="text" name="ThirdGradingGradeSub3" id="ThirdGradingGradeSub3" class="aSB_inpbx spec"><br>
                            <label for="ThridGradingGradeSub4">Subject 4</label>
                            <input type="text" name="ThirdGradingGradeSub4" id="ThirdGradingGradeSub4" class="aSB_inpbx spec"><br>
                            <label for="ThridGradingGradeSub5">Subject 5</label>
                            <input type="text" name="ThirdGradingGradeSub5" id="ThirdGradingGradeSub5" class="aSB_inpbx spec"><br>
                            <label for="ThridGradingGradeSub6">Subject 6</label>
                            <input type="text" name="ThirdGradingGradeSub6" id="ThirdGradingGradeSub6" class="aSB_inpbx spec"><br>
                            <input type="submit" value="Change" name="change" class="btn">
                            <button type="button" onclick="closeThird()" class="btn">Cancel</button>
                            <input type="hidden" value="Thrid" name="checker">
                            </form>
                        </dialog>
                        <dialog class="fourthgrading grdChange">
                        <form action="mockUserdata.php?LRN=<?php echo $LRN; ?>" method="POST">
                            <label for="ForuthGradingGradeSub1">Subject 1</label>
                            <input type="text" name="ForuthGradingGradeSub1" id="ForuthGradomgGradeSub1" class="aSB_inpbx spec"><br>
                            <label for="ForuthGradingGradeSub2">Subject 2</label>
                            <input type="text" name="ForuthGradingGradeSub2" id="ForuthGradomgGradeSub2" class="aSB_inpbx spec"><br>
                            <label for="ForuthGradingGradeSub3">Subject 3</label>
                            <input type="text" name="ForuthGradingGradeSub3" id="ForuthGradomgGradeSub3" class="aSB_inpbx spec"><br>
                            <label for="ForuthGradingGradeSub4">Subject 4</label>
                            <input type="text" name="ForuthGradingGradeSub4" id="ForuthGradomgGradeSub4" class="aSB_inpbx spec"><br>
                            <label for="ForuthGradingGradeSub5">Subject 5</label>
                            <input type="text" name="ForuthGradingGradeSub5" id="ForuthGradomgGradeSub5" class="aSB_inpbx spec"><br>
                            <label for="ForuthGradingGradeSub6">Subject 6</label>
                            <input type="text" name="ForuthGradingGradeSub6" id="ForuthGradomgGradeSub6" class="aSB_inpbx spec"><br>
                            <input type="submit" value="Change" name="change" class="btn">
                            <button type="button" onclick="closeFourth()" class="btn">Cancel</button>
                            <input type="hidden" value="Fourth" name="checker">
                            </form>
                        </dialog>
                </dialog>
                <?php 
                //UPDATE GRADES
                try{
                    $pdo = connect();
                    if(isset($_POST['change'])){
                        $check = $_POST['checker'];
                        if($check == "First"){
                            $FirstGradingGradeSub1 = $_POST['FirstGradingGradeSub1'];
                            $FirstGradingGradeSub2 = $_POST['FirstGradingGradeSub2'];
                            $FirstGradingGradeSub3 = $_POST['FirstGradingGradeSub3'];
                            $FirstGradingGradeSub4 = $_POST['FirstGradingGradeSub4'];
                            $FirstGradingGradeSub5 = $_POST['FirstGradingGradeSub5'];
                            $FirstGradingGradeSub6 = $_POST['FirstGradingGradeSub6'];
                            $sqlUp1= "UPDATE tblgrades SET FirstGradingGradeSub1 = :FirstGradingGradeSub1, 
                            FirstGradingGradeSub2 =:FirstGradingGradeSub2, 
                            FirstGradingGradeSub3 =:FirstGradingGradeSub3, 
                            FirstGradingGradeSub4 =:FirstGradingGradeSub4, 
                            FirstGradingGradeSub5 =:FirstGradingGradeSub5, 
                            FirstGradingGradeSub6 =:FirstGradingGradeSub6 WHERE LRN=:LRN";
                            $stmtupgr= $pdo->prepare($sqlUp1);
                            $stmtupgr->bindParam(':FirstGradingGradeSub1', $FirstGradingGradeSub1);
                            $stmtupgr->bindParam(':FirstGradingGradeSub2', $FirstGradingGradeSub2);
                            $stmtupgr->bindParam(':FirstGradingGradeSub3', $FirstGradingGradeSub3);
                            $stmtupgr->bindParam(':FirstGradingGradeSub4', $FirstGradingGradeSub4);
                            $stmtupgr->bindParam(':FirstGradingGradeSub5', $FirstGradingGradeSub5);
                            $stmtupgr->bindParam(':FirstGradingGradeSub6', $FirstGradingGradeSub6);
                            $stmtupgr->bindParam(':LRN', $LRN);
                            $stmtupgr->execute();
                        }
                        elseif($check == "Second"){
                            $SecondGradingGradeSub1 = $_POST['SecondGradingGradeSub1'];
                            $SecondGradingGradeSub2 = $_POST['SecondGradingGradeSub2'];
                            $SecondGradingGradeSub3 = $_POST['SecondGradingGradeSub3'];
                            $SecondGradingGradeSub4 = $_POST['SecondGradingGradeSub4'];
                            $SecondGradingGradeSub5 = $_POST['SecondGradingGradeSub5'];
                            $SecondGradingGradeSub6 = $_POST['SecondGradingGradeSub6'];
                            $sqlUp1= "UPDATE tblgrades SET SecondGradingGradeSub1 = :SecondGradingGradeSub1, 
                            SecondGradingGradeSub2 =:SecondGradingGradeSub2, 
                            SecondGradingGradeSub3 =:SecondGradingGradeSub3, 
                            SecondGradingGradeSub4 =:SecondGradingGradeSub4, 
                            SecondGradingGradeSub5 =:SecondGradingGradeSub5, 
                            SecondGradingGradeSub6 =:SecondGradingGradeSub6 WHERE LRN=:LRN";
                            $stmtupgr= $pdo->prepare($sqlUp1);
                            $stmtupgr->bindParam(':SecondGradingGradeSub1', $SecondGradingGradeSub1);
                            $stmtupgr->bindParam(':SecondGradingGradeSub2', $SecondGradingGradeSub2);
                            $stmtupgr->bindParam(':SecondGradingGradeSub3', $SecondGradingGradeSub3);
                            $stmtupgr->bindParam(':SecondGradingGradeSub4', $SecondGradingGradeSub4);
                            $stmtupgr->bindParam(':SecondGradingGradeSub5', $SecondGradingGradeSub5);
                            $stmtupgr->bindParam(':SecondGradingGradeSub6', $SecondGradingGradeSub6);
                            $stmtupgr->bindParam(':LRN', $LRN);
                            $stmtupgr->execute();
                        }
                        elseif($check == "Third"){
                            $ThirdGradingGradeSub1 = $_POST['ThirdGradingGradeSub1'];
                            $ThirdGradingGradeSub2 = $_POST['ThirdGradingGradeSub2'];
                            $ThirdGradingGradeSub3 = $_POST['ThirdGradingGradeSub3'];
                            $ThirdGradingGradeSub4 = $_POST['ThirdGradingGradeSub4'];
                            $ThirdGradingGradeSub5 = $_POST['ThirdGradingGradeSub5'];
                            $ThirdGradingGradeSub6 = $_POST['ThirdGradingGradeSub6'];
                            $sqlUp1= "UPDATE tblgrades SET ThirdGradingGradeSub1 = :ThirdGradingGradeSub1, 
                            ThirdGradingGradeSub2 =:ThirdGradingGradeSub2, 
                            ThirdGradingGradeSub3 =:ThirdGradingGradeSub3, 
                            ThirdGradingGradeSub4 =:ThirdGradingGradeSub4, 
                            ThirdGradingGradeSub5 =:ThirdGradingGradeSub5, 
                            ThirdGradingGradeSub6 =:ThirdGradingGradeSub6 WHERE LRN=:LRN";
                            $stmtupgr= $pdo->prepare($sqlUp1);
                            $stmtupgr->bindParam(':ThirdGradingGradeSub1', $ThirdGradingGradeSub1);
                            $stmtupgr->bindParam(':ThirdGradingGradeSub2', $ThirdGradingGradeSub2);
                            $stmtupgr->bindParam(':ThirdGradingGradeSub3', $ThirdGradingGradeSub3);
                            $stmtupgr->bindParam(':ThirdGradingGradeSub4', $ThirdGradingGradeSub4);
                            $stmtupgr->bindParam(':ThirdGradingGradeSub5', $ThirdGradingGradeSub5);
                            $stmtupgr->bindParam(':ThirdGradingGradeSub6', $ThirdGradingGradeSub6);
                            $stmtupgr->bindParam(':LRN', $LRN);
                            $stmtupgr->execute(); 
                        }
                        elseif($check == "Fourth"){
                            $ForuthGradingGradeSub1 = $_POST['ForuthGradingGradeSub1'];
                            $ForuthGradingGradeSub2 = $_POST['ForuthGradingGradeSub2'];
                            $ForuthGradingGradeSub3 = $_POST['ForuthGradingGradeSub3'];
                            $ForuthGradingGradeSub4 = $_POST['ForuthGradingGradeSub4'];
                            $ForuthGradingGradeSub5 = $_POST['ForuthGradingGradeSub5'];
                            $ForuthGradingGradeSub6 = $_POST['ForuthGradingGradeSub6'];
                            $sqlUp1= "UPDATE tblgrades SET ForuthGradingGradeSub1 = :ForuthGradingGradeSub1, 
                            ForuthGradingGradeSub2 =:ForuthGradingGradeSub2, 
                            ForuthGradingGradeSub3 =:ForuthGradingGradeSub3, 
                            ForuthGradingGradeSub4 =:ForuthGradingGradeSub4, 
                            ForuthGradingGradeSub5 =:ForuthGradingGradeSub5, 
                            ForuthGradingGradeSub6 =:ForuthGradingGradeSub6 WHERE LRN=:LRN";
                            $stmtupgr= $pdo->prepare($sqlUp1);
                            $stmtupgr->bindParam(':ForuthGradingGradeSub1', $ForuthGradingGradeSub1);
                            $stmtupgr->bindParam(':ForuthGradingGradeSub2', $ForuthGradingGradeSub2);
                            $stmtupgr->bindParam(':ForuthGradingGradeSub3', $ForuthGradingGradeSub3);
                            $stmtupgr->bindParam(':ForuthGradingGradeSub4', $ForuthGradingGradeSub4);
                            $stmtupgr->bindParam(':ForuthGradingGradeSub5', $ForuthGradingGradeSub5);
                            $stmtupgr->bindParam(':ForuthGradingGradeSub6', $ForuthGradingGradeSub6);
                            $stmtupgr->bindParam(':LRN', $LRN);
                            $stmtupgr->execute();
                        }
                    }

                }catch(PDOException $e) {
                    // Display an error message if unable to connect to the database
                    echo "Connection failed: " . $e->getMessage();
                  }
                  $pdo = null;
                
                ?>
                <div class="head">
                    <h1>Student's Grades</h1>
                    <div class="opt" <?php if(isset($_SESSION['student'])){echo "style='display:none;'";}?>>
                            <div class="modifyBtn btn" onclick="openModG()">Modify</div>
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