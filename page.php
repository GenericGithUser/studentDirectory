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
        <p><a href="login.php"><img src="img/logout.png" class="logout">Logout?</a></p>
    </div>
    <div class="banner">
        <h2>Hello <!--Name h ere--></h2>
        <h2>Welcome to the Student Directory</h2>
    </div>
    <div class="content">
        <h1>What do you want to do?</h1>
        <div class="container">
            <div class="search opt" onclick="show1()">
                <img src="img/search-icon.svg" alt="missing">
                <h2>Search for your Records?</h2>
            </div>
            <div class="viewAll opt" onclick="show2()">
                <img src="img/eye-icon.svg" alt="missing">
                <h2>View all of your records?</h2>
            </div>
        </div>
        <div class="searchAndResults">
            <div class="searchbox">
                <input type="text" id="inpbx">
                <button id="srchbtn">Search</button>
            </div>
           <div class="results">
             <h2>Here's your results</h2>
             <div class="resultbx">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolor illum in veniam inventore animi fugit necessitatibus voluptatum eligendi distinctio, nihil molestias, repudiandae, qui explicabo nisi rerum eveniet nostrum voluptas obcaecati. 
             </div>
           </div>
        </div>
        <div class="AllRecords">
            <h2>Here's All of your records</h2>
        </div>
    </div>
</body>
<script>
    function show1(){
        let SAR = document.querySelector('.searchAndResults');
        let AR = document.querySelector('.AllRecords');
        SAR.style.display = "block";
        AR.style.display = "none";
    }
    function show2(){
        let SAR = document.querySelector('.searchAndResults');
        let AR = document.querySelector('.AllRecords');
        SAR.style.display = "none";
        AR.style.display = "block";
    }
</script>
</html>