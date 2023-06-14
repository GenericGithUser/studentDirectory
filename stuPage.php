<?php
session_start();
// Include Connection Function
include 'credentials.php';
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login.php
    // header("Location: login.php");
    // exit;
    $notLoggedIn = true;
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
        <?php if(isset($notLoggedIn)){echo'<p><a href="login.php"><img src="img/logout.png" class="logout">LogIN</a></p>';}else{echo '<p><a href="logout.php"><img src="img/logout.png" class="logout">Logout?</a></p>';} ?>
    </div>
    <div class="banner">
        <h2>Hello <?php if (isset($notLoggedIn)){echo "Visitor";}else {echo $_SESSION['user_name'];} ?> </h2>
        <h2>Welcome to the Student Directory</h2>
    </div>
    <div class="content">
        <h1>What do you want to do?</h1>
        <!--Options-->
        <div class="container"  <?php if (isset($notLoggedIn)) {echo"style='display:none;'";}?>>
            <div class="search opt" onclick="show1()">
                <img src="img/search-icon.svg" alt="missing">
                <h2>Search for a specific student?</h2>
            </div>
            <div class="viewAll opt" onclick="show2()"?>
                <img src="img/eye-icon.svg" alt="missing">
                <h2>View all students?</h2>
            </div>
            <a style="text-decoration: none; color: black;" href="mockUserdata.php?LRN=<?php echo $_SESSION['user_id']?>">
             <div class="addStu opt viewProf">
               <img src="img/account.png" alt="missing">
                <h2>View Your Profile?</h2>
            </div></a>
        </div>
        <!--Not logged in options-->
        <div class="container specbox" <?php if (isset($notLoggedIn)) {echo"style='display:block;'";}else{echo "style='display:none;'";}?>>
            <div class="search opt specop" onclick="show1()">
                <img src="img/search-icon.svg" alt="missing">
                <h2>Search for a specific student?</h2>
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
                                resultLink.href = `mockUserdata.php?LRN=${result.LRN}`;
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
             try{
                $pdo = connect();
                // Set the PDO error mode to exception
                 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 $viewAllSQL = "SELECT * FROM tblstudents";
                 $stmt = $pdo->prepare($viewAllSQL);
                 $stmt->execute();
                 $viewAll = $stmt->fetchAll(PDO::FETCH_ASSOC);
                //show all results
                 if(count($viewAll)>0){
                    foreach($viewAll as $result){
                        echo "<a href='mockUserdata.php?LRN=".$result['LRN']."'><div class='result'>".$result['FirstName']." ".$result['LastName']."</div></a>";
                    }
                 }

             }catch(PDOException $e) {
                // Display an error message if unable to connect to the database
                echo "Connection failed: " . $e->getMessage();
              }
              $pdo = null;
             ?>
            </div>
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