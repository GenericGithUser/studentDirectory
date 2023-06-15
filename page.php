<?php
session_start();
// Include Connection Function
include 'credentials.php';
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login.php
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style2.css">
    <title>Document</title>
</head>

<body>
    <div class="navbar">
        <img src="img/logo.png" alt="imgmissing">
        <h3>San Francisco High School Student's Directory</h3>
        <p><a href="logout.php"><img src="img/logout.png" class="logout">Logout?</a></p>
    </div>
    <div class="banner">
        <h2>Hello <?php echo $_SESSION['user_name'] ?> </h2>
        <h2>Welcome to the Student Directory</h2>
    </div>
    <div class="content">
        <h1>What do you want to do?</h1>
        <!--Options-->
        <div class="container">
            <div class="search opt" onclick="show1()">
                <img src="img/search-icon.svg" alt="missing">
                <h2>Search for a specific student?</h2>
            </div>
            <div class="viewAll opt" onclick="show2()">
                <img src="img/eye-icon.svg" alt="missing">
                <h2>View all students?</h2>
            </div>
            <div class="addStu opt" onclick="show3()">
                <img src="img/add-user.png" alt="missing">
                <h2>Add a Student?</h2>
            </div>
        </div>
        <!--Search Option-->
        <div class="searchAndResults">
            <h2>Search for a specific student</h2>
            <div class="searchForm">
                <form id="searchForm">
                    <input type="text" id="searchQuery" placeholder="Enter student name" required>
                    <button type="submit" id="srchbtn" onclick="mockSearch()">Search</button>
                </form>
            </div>
            <div class="results">
                <h2>Here are your results</h2>
                <div class="resultbx" id="searchResults">

                </div>
            </div>
        </div>
        <script>
            // Function to handle the form submission using AJAX
            function handleSearchForm(event) {
                event.preventDefault(); // Prevent form submission from reloading the page

                const query = document.getElementById('searchQuery').value;
                const searchResultsContainer = document.getElementById('searchResults');

                // Create a new XMLHttpRequest object
                const xhr = new XMLHttpRequest();

                // Configure the request
                xhr.open('GET', `search.php?query=${encodeURIComponent(query)}`, true);

                // Set the response type
                xhr.responseType = 'json';

                // Define the callback function for the AJAX request
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const searchResults = xhr.response;

                        // Clear the search results container
                        searchResultsContainer.innerHTML = '';

                        if (searchResults.length > 0) {
                            // Iterate over the search results and create HTML elements
                            searchResults.forEach(function(result) {
                                const resultLink = document.createElement('a');
                                resultLink.href = `studentData.php?LRN=${result.LRN}`;
                                resultLink.textContent = result.FirstName + ' ' + result.LastName;
                                const resultDiv = document.createElement('div');
                                resultDiv.classList.add('result');
                                resultDiv.appendChild(resultLink);
                                searchResultsContainer.appendChild(resultDiv);
                            });
                        } else {
                            searchResultsContainer.textContent = 'No results found.';
                        }
                    } else {
                        console.error('Error: ' + xhr.status);
                    }
                };

                // Send the request
                xhr.send();
            }

            // Add event listener for the form submission
            document.getElementById('searchForm').addEventListener('submit', handleSearchForm);
        </script>

        <!--View All students option-->
        <!--I am sure there's a better way to do this but....-->
        <!--Should Probably just moved the connection to the top-->
        <div class="AllRecords">
            <h2>List of all students</h2>
            <div class="list">
                <?php
                try {
                    $pdo = connect();
                    // Set the PDO error mode to exception
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $viewAllSQL = "SELECT * FROM tblstudents";
                    $stmt = $pdo->prepare($viewAllSQL);
                    $stmt->execute();
                    $viewAll = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    //show all results
                    if (count($viewAll) > 0) {
                        foreach ($viewAll as $result) {
                            if (isset($_SESSION['user_id'])) {
                                echo "<a href='studentData.php?LRN=" . $result['LRN'] . "'><div class='result'>" . $result['FirstName'] . " " . $result['LastName'] . "</div></a>";
                            } else {
                                echo "<a href='login.php'><div class='result'>" . $result['FirstName'] . " " . $result['LastName'] . "</div></a>";
                            }
                        }
                        
                    }
                } catch (PDOException $e) {
                    // Display an error message if unable to connect to the database
                    echo "Connection failed: " . $e->getMessage();
                }
                $pdo = null;
                ?>
            </div>
        </div>
        <!--Add a Student Option-->
        <!--Sorry for long form and a lot of divs-->
        <div class="addStuBox">
            <h2>Add a Student</h2>
            <form action="page.php" class="aSB_form" method="POST">
                <div class="FCont">
                    <label for="LRN" style="width: 300px; margin-left: -150px;">Learner's Reference Number</label>
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
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" class="aSB_inpbx" required>
                </div>
                <div class="FCont">
                    <label for="password">Password</label>
                    <input type="text" id="password" name="password" class="aSB_inpbx" required>
                </div>
                <div class="FCont">
                    <input type="submit" class="aSB_btn" value="Submit">
                    <button type="reset" class="aSB_btn aSB_special">Reset Form?</button>
                </div>
            </form>
            <?php
            //Apparently Making it inline makes the inputting process work
            //This just made the code longer i guess?
            try {
                $pdo = connect();
                // Set the PDO error mode to exception
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                if ($_SERVER['REQUEST_METHOD'] === "POST") {
                    //get the varibles
                    $LRN = $_POST['LRN'];
                    $fname = $_POST['fname'];
                    $mname = substr($_POST['mname'], 0, 1);
                    $lname = $_POST['lname'];
                    $age = $_POST['age'];
                    $gender = $_POST['gender'];
                    $Birthday = $_POST['Birthday'];
                    $GrdLvl = $_POST['GrdLvl'];
                    $strand = $_POST['strand'];
                    $denrolld = date("Y-m-d");
                    $pNumber = $_POST['pNumber'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    //SQL Code and Execution
                    $sql = "INSERT INTO tblstudents (LRN, FirstName, MiddleInitial, LastName, Age, Gender, Birthday, GradeLevel, Strand, DateEnrolled, PhoneNumber, email, password)
                      VALUES(:LRN, :fname, :mname, :lname, :age, :gender, :Birthday, :grdlvl, :strand, :denrolld, :pNumber, :email, :password)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':LRN', $LRN);
                    $stmt->bindParam(':fname', $fname);
                    $stmt->bindParam(':mname', $mname);
                    $stmt->bindParam(':lname', $lname);
                    $stmt->bindParam(':age', $age);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':Birthday', $Birthday);
                    $stmt->bindParam(':grdlvl', $GrdLvl);
                    $stmt->bindParam(':strand', $strand);
                    $stmt->bindParam(':denrolld', $denrolld);
                    $stmt->bindParam(':pNumber', $pNumber);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $hashed_password);
                    if ($stmt->execute()) {
                    } else {
                        $errorInfo = $stmt->errorInfo();
                        echo "Error: " . $errorInfo[2];

                      }
                      $sqlAddForeign = "INSERT INTO grades (LRN)
                           VALUES (:LRN);";
                        $stmt = $pdo->prepare($sqlAddForeign);
                        $stmt->bindParam(':LRN', $LRN);
                        if ($stmt->execute()) {
                        
                        } else {
                          $errorInfo = $stmt->errorInfo();
                          echo "Error: " . $errorInfo[2];
                        }
                  }
              
            } catch (PDOException $e) {

                // Display an error message if unable to connect to the database
                echo "Connection failed: " . $e->getMessage();
            }
            $pdo = null
            ?>
        </div>
    </div>
    <div class="footer">
        <h3>GroupWhite</h3>
        <p>wordwordwordword</p>
        <p><a href="">About and Contact Us</a></p>
    </div>
</body>

<script src="./scriptspage.js"></script>

</html>