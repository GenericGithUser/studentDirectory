<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="studentData.css">
    <title>Student Data</title>
</head>

<body>
    <?php
    // Include Connection Function
    include 'credentials.php';
    include './redirect.php';
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login.php
        header("Location: login.php");
        exit;
    }

    $LRN = $_GET['LRN'];

    // Handle form submission for updating student data
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true) {
        try {
            $pdo = connect();
            // Set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $lrn = $_POST['lrn'];
            $firstName = $_POST['firstName'];
            $middleInitial = $_POST['middleInitial'];
            $lastName = $_POST['lastName'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $birthday = $_POST['birthday'];
            $gradeLevel = $_POST['gradeLevel'];
            $strand = $_POST['strand'];
            $dateEnrolled = $_POST['dateEnrolled'];
            $phoneNumber = $_POST['phoneNumber'];
            $email = $_POST['email'];

            // Update the student data in the database
            $updateStmt = $pdo->prepare("UPDATE tblstudents SET
                FirstName = :firstName,
                MiddleInitial = :middleInitial,
                LastName = :lastName,
                Age = :age,
                Gender = :gender,
                Birthday = :birthday,
                GradeLevel = :gradeLevel,
                Strand = :strand,
                DateEnrolled = :dateEnrolled,
                PhoneNumber = :phoneNumber,
                email = :email
                WHERE LRN = :lrn");

            $updateStmt->execute([
                ':lrn' => $lrn,
                ':firstName' => $firstName,
                ':middleInitial' => $middleInitial,
                ':lastName' => $lastName,
                ':age' => $age,
                ':gender' => $gender,
                ':birthday' => $birthday,
                ':gradeLevel' => $gradeLevel,
                ':strand' => $strand,
                ':dateEnrolled' => $dateEnrolled,
                ':phoneNumber' => $phoneNumber,
                ':email' => $email
            ]);

            // Redirect to the updated student data page
            header("Location: studentData.php?LRN=" . $lrn);
            exit;
        } catch (PDOException $e) {
            // Display an error message if unable to connect to the database
            echo "Connection failed: " . $e->getMessage();
        }
    }

    try {
        $pdo = connect();
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $viewDetails = "SELECT * FROM tblstudents WHERE LRN = :LRN";
        $stmt = $pdo->prepare($viewDetails);
        $stmt->bindParam(':LRN', $LRN);
        $stmt->execute();
        $select = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($select)) {
            echo "No student found for the given LRN.";
            exit;
        }

        $row = $select[0];
    } catch (PDOException $e) {
        // Display an error message if unable to connect to the database
        echo "Connection failed: " . $e->getMessage();
    }

    $pdo = null;
    ?>
    <div class="container">
        <div class="student-info">

            <h2>Student Information</h2>
            <table>
                <tr>
                    <td class="field-label">LRN</td>
                    <td class="field-value"><?php echo $row['LRN']; ?></td>
                </tr>
                <tr>
                    <td class="field-label">First Name</td>
                    <td class="field-value"><?php echo $row['FirstName']; ?></td>
                </tr>
                <tr>
                    <td class="field-label">Middle Initial</td>
                    <td class="field-value"><?php echo $row['MiddleInitial']; ?></td>
                </tr>
                <tr>
                    <td class="field-label">Last Name</td>
                    <td class="field-value"><?php echo $row['LastName']; ?></td>
                </tr>
                <tr>
                    <td class="field-label">Age</td>
                    <td class="field-value"><?php echo $row['Age']; ?></td>
                </tr>
                <tr>
                    <td class="field-label">Gender</td>
                    <td class="field-value"><?php echo $row['Gender']; ?></td>
                </tr>
                <tr>
                    <td class="field-label">Birthday</td>
                    <td class="field-value"><?php echo $row['Birthday']; ?></td>
                </tr>
                <tr>
                    <td class="field-label">Grade Level</td>
                    <td class="field-value"><?php echo $row['GradeLevel']; ?></td>
                </tr>
                <tr>
                    <td class="field-label">Strand</td>
                    <td class="field-value"><?php echo $row['Strand']; ?></td>
                </tr>
                <tr>
                    <td class="field-label">Date Enrolled</td>
                    <td class="field-value"><?php echo $row['DateEnrolled']; ?></td>
                </tr>
                <tr>
                    <td class="field-label">Phone Number</td>
                    <td class="field-value"><?php echo $row['PhoneNumber']; ?></td>
                </tr>
                <tr>
                    <td class="field-label">Email</td>
                    <td class="field-value"><?php echo $row['email']; ?></td>
                </tr>
            </table>

            <?php
            if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true) {
                echo '<button onclick="openModal()" class="edit-button">Update</button>
            <button onclick="openDelModal()" class="edit-button delete-button">Delete</button>';
            }
            ?>
            <a href="index.php" class="spec">
                <div class="goBackbtn btn">Go Back?</div>
            </a>

            <!-- Modal -->
            <div id="myModal" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h2>Update Student Information</h2>
                    <form method="POST" action="">
                        <input type="hidden" name="lrn" value="<?php echo $row['LRN']; ?>">
                        <label for="firstName">First Name:</label>
                        <input type="text" name="firstName" value="<?php echo $row['FirstName']; ?>"><br>

                        <label for="middleInitial">Middle Initial:</label>
                        <input type="text" name="middleInitial" value="<?php echo $row['MiddleInitial']; ?>"><br>

                        <label for="lastName">Last Name:</label>
                        <input type="text" name="lastName" value="<?php echo $row['LastName']; ?>"><br>

                        <label for="age">Age:</label>
                        <input type="text" name="age" value="<?php echo $row['Age']; ?>"><br>

                        <label for="gender">Gender:</label>
                        <input type="text" name="gender" value="<?php echo $row['Gender']; ?>"><br>

                        <label for="birthday">Birthday:</label>
                        <input type="text" name="birthday" value="<?php echo $row['Birthday']; ?>"><br>

                        <label for="gradeLevel">Grade Level:</label>
                        <input type="text" name="gradeLevel" value="<?php echo $row['GradeLevel']; ?>"><br>

                        <label for="strand">Strand:</label>
                        <input type="text" name="strand" value="<?php echo $row['Strand']; ?>"><br>

                        <label for="dateEnrolled">Date Enrolled:</label>
                        <input type="text" name="dateEnrolled" value="<?php echo $row['DateEnrolled']; ?>"><br>

                        <label for="phoneNumber">Phone Number:</label>
                        <input type="text" name="phoneNumber" value="<?php echo $row['PhoneNumber']; ?>"><br>

                        <label for="email">Email:</label>
                        <input type="text" name="email" value="<?php echo $row['email']; ?>"><br>

                        <input type="submit" value="Update" class="edit-button">
                    </form>
                </div>
            </div>
            <div id="myModal" class="modal modal-delete">

                <!--Delete Modal content -->
                <div class="modal-content">
                    <span class="close" onclick="closeDelModal()">&times;</span>
                    <h2>Delete a Student</h2>
                    <form action="delete.php?LRN=<?php echo $LRN ?>" method="post">
                        <h2>Are you sure you want to delete this student?</h2>
                        <input type="submit" value="YES" name="submit" class="deleteBtn btn">
                        <button type="button" onclick="closeDelModal()" class="modifyBtn btn">NO</button>
                    </form>

                </div>
            </div>

        </div>


        <div class="grades-table-cont">
            <h2>Grades</h2>

            <table class="grades-table">
                <tr>
                    <th>Subject</th>
                    <th>Quarter 1</th>
                    <th>Quarter 2</th>
                    <th>Quarter 3</th>
                    <th>Quarter 4</th>
                </tr>
                <?php
                // Retrieve the grades for the student based on LRN
                try {
                    $pdo = connect();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $gradesQuery = "SELECT * FROM grades WHERE LRN = :LRN";
                    $gradesStmt = $pdo->prepare($gradesQuery);
                    $gradesStmt->bindParam(':LRN', $LRN);
                    $gradesStmt->execute();
                    $grades = $gradesStmt->fetchAll(PDO::FETCH_ASSOC);

                    // Loop through the grades and display them in the table
                    for ($i = 1; $i <= 8; $i++) {
                        echo '<tr>';
                        echo '<td>Subject ' . $i . '</td>';
                        echo '<td>' . $grades[0]['Quarter1_Subject' . $i] . '</td>';
                        echo '<td>' . $grades[0]['Quarter2_Subject' . $i] . '</td>';
                        echo '<td>' . $grades[0]['Quarter3_Subject' . $i] . '</td>';
                        echo '<td>' . $grades[0]['Quarter4_Subject' . $i] . '</td>';
                        echo '</tr>';
                    }
                } catch (PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                ?>
            </table>
          
            <?php
            if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == true) {
                echo '<button id="openGradeUpdaterButton" class="edit-button">Open Grade Updater</button>';
            }
            ?>
            <!-- Grade Updater Modal -->
            <div id="gradeUpdaterModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeGradeUpdaterModal()">&times;</span>
                    <h2>Update Grades</h2>
                    <form action="updateGrades.php?LRN=<?php echo urlencode($LRN); ?>" method="POST">
                        <table class="grades-table">
                            <tr>
                                <th>Subject</th>
                                <th>Quarter 1</th>
                                <th>Quarter 2</th>
                                <th>Quarter 3</th>
                                <th>Quarter 4</th>
                            </tr>
                            <?php
                            // Retrieve the grades for the student based on LRN
                            try {
                                $pdo = connect();
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                $gradesQuery = "SELECT * FROM grades WHERE LRN = :LRN";
                                $gradesStmt = $pdo->prepare($gradesQuery);
                                $gradesStmt->bindParam(':LRN', $LRN);
                                $gradesStmt->execute();
                                $grades = $gradesStmt->fetchAll(PDO::FETCH_ASSOC);

                                // Loop through the grades and display them in the table
                                for ($i = 1; $i <= 8; $i++) {
                                    echo '<tr>';
                                    echo '<td>Subject ' . $i . '</td>';
                                    echo '<td><input type="text" name="quarter1_subject' . $i . '" value="' . $grades[0]['Quarter1_Subject' . $i] . '"></td>';
                                    echo '<td><input type="text" name="quarter2_subject' . $i . '" value="' . $grades[0]['Quarter2_Subject' . $i] . '"></td>';
                                    echo '<td><input type="text" name="quarter3_subject' . $i . '" value="' . $grades[0]['Quarter3_Subject' . $i] . '"></td>';
                                    echo '<td><input type="text" name="quarter4_subject' . $i . '" value="' . $grades[0]['Quarter4_Subject' . $i] . '"></td>';
                                    echo '</tr>';
                                }
                            } catch (PDOException $e) {
                                echo "Connection failed: " . $e->getMessage();
                            }
                            ?>
                        </table>
                        <input type="submit" value="Update Grades" class="special">
                    </form>
                </div>
            </div>

            <script>
                // Function to open the modal
                function openModal() {
                    document.getElementById("myModal").style.display = "block";
                }

                // Function to close the modal
                function closeModal() {
                    document.getElementById("myModal").style.display = "none";
                }

                function openDelModal() {
                    document.querySelector(".modal-delete").style.display = "block";
                }

                function closeDelModal() {
                    document.querySelector(".modal-delete").style.display = "none";
                }
                // Function to open the gradeUpdaterModal
                function openGradeUpdaterModal() {
                    document.getElementById("gradeUpdaterModal").style.display = "block";
                }

                // Function to close the gradeUpdaterModal
                function closeGradeUpdaterModal() {
                    document.getElementById("gradeUpdaterModal").style.display = "none";
                }

                // Attach event listeners to open and close gradeUpdaterModal buttons
                document.getElementById("openGradeUpdaterButton").addEventListener("click", openGradeUpdaterModal);
                document.getElementById("closeGradeUpdaterButton").addEventListener("click", closeGradeUpdaterModal);
            </script>
        </div>
    </div>
</body>

</html>