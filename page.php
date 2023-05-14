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
            <div class="searchbox">
                <form action="">
                    <input type="text" id="inpbx">
                    <button id="srchbtn" onclick="mockSearch()" type="button">Search</button>
                    <h3>Narrow Down Your Search</h3>
                        <label for="gradeLvl" class="label">Grade Level</label>
                        <select name="gradeLvl" id="gradeLvl" class="selectOption" >
                            <option value="none">Select A Grade</option>
                            <option value="Grd7">Grade 7</option>
                            <option value="Grd8">Grade 8</option>
                            <option value="Grd9">Grade 9</option>
                            <option value="Grd10">Grade 10</option>
                            <option value="Grd11">Grade 11</option>
                            <option value="Grd12">Grade 12</option>
                        </select>
                    <label for="section" class="label">Section Name</label>
                    <select name="section" id="section" class="selectOption">
                        <option value="1">opt1</option>
                        <option value="2">opt2</option>
                        <option value="3">opt3</option>
                    </select>
                </form>
            </div>
           <div class="results">
             <h2>Here's your results</h2>
             <div class="resultbx">
             <a href="mockUserdata.php"><div class="result">Sample Result</div></a>
             <a href="mockUserdata.php"><div class="result">Sample Result</div></a>
             <a href="mockUserdata.php"><div class="result">Sample Result</div></a>
             </div>
           </div>
        </div>
        <!--View All students option-->
        <div class="AllRecords">
            <h2>List of all students</h2>
            <div class="list">
            <a href="mockUserdata.php"><div class="result">Sample Result</div></a>
             <a href="mockUserdata.php"><div class="result">Sample Result</div></a>
             <a href="mockUserdata.php"><div class="result">Sample Result</div></a>
            </div>
        </div>
        <!--Add a Student Option-->
        <!--Sorry for long form and a lot of divs-->
        <div class="addStuBox">
            <h2>Add a Student</h2>
            <form action="" class="aSB_form">
            <div class="FCont">
                    <label for="LRN" style="width: 300px; margin-left: -150px;">Learner's Reference Number</label>
                    <input type="number" id="LRN" name="LRN" class="aSB_inpbx" maxlength="12">
                </div>
                <div class="FCont">
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname" class="aSB_inpbx">
                </div>
                <div class="FCont">
                    <label for="mname">Middle Name</label>
                    <input type="text" id="mname" name="mname" class="aSB_inpbx" maxlength="10">
                </div>
                <div class="FCont">
                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lname" class="aSB_inpbx">
                </div>
                <div class="FCont">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" class="aSB_inpbx" style="width:80px" maxlength="10" min="1">
                    <label for="gender" style="width:100px">Gender</label>
                    <select name="gender" id="gender" class="selectOption">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="FCont">
                    <label for="Birthday">Date of Birth</label>
                    <input type="date" name="Birthday" id="Birthday">
                </div>
                <div class="FCont">
                    <label for="GrdLvl" style="width:260px">Grade to be enrolled</label>
                    <select name="GrdLvl" id="GrdLvl" class="selectOption" >
                            <option value="none">Select A Grade</option>
                            <option value="Grd7">Grade 7</option>
                            <option value="Grd8">Grade 8</option>
                            <option value="Grd9">Grade 9</option>
                            <option value="Grd10">Grade 10</option>
                            <option value="Grd11">Grade 11</option>
                            <option value="Grd12">Grade 12</option>
                        </select>
                </div>
                <div class="FCont">
                    <label for="strand">Strand</label>
                    <select name="strand" id="strand" class="selectOption">
                        <option value="STEM">STEM</option>
                        <option value="ABM">ABM</option>
                        <option value="GAS">GAS</option>
                        <option value="TVL">TVL</option>
                    </select>
                    <label for="pNumber">Phone Number</label>
                    <input type="number" name="pNumber" id="pNumber" style="width:200px" maxlength="12" class="aSB_inpbx">
                </div>
                <div class="FCont">
                    <button type="button" class="aSB_btn">Submit</button>
                    <button type="reset" class="aSB_btn aSB_special">Reset Form?</button>
                </div>
            </form>
        </div>
    </div>
    <div class="footer">
        <h3>GroupWhite</h3>
        <p>wordwordwordword</p>
        <p><a href="">About and Contact Us</a></p>
    </div>
</body>
<!--Should Probably Migrate this to a different file-->
<script>
    //Function for Buttons
    function show1(){
        const SAR = document.querySelector('.searchAndResults');
        const AR = document.querySelector('.AllRecords');
        const ANS = document.querySelector('.addStuBox');
        SAR.style.display = "block";
        AR.style.display = "none";
        ANS.style.display = "none"
    }
    function show2(){
        const SAR = document.querySelector('.searchAndResults');
        const AR = document.querySelector('.AllRecords');
        const ANS = document.querySelector('.addStuBox');
        SAR.style.display = "none";
        AR.style.display = "block";
        ANS.style.display = "none"
    }
    function show3(){
        const SAR = document.querySelector('.searchAndResults');
        const AR = document.querySelector('.AllRecords');
        const ANS = document.querySelector('.addStuBox');
        SAR.style.display = "none";
        AR.style.display = "none";
        ANS.style.display = "block"
    }
    //End of Function For Buttons
    //Function for mock search button
    function mockSearch(){
        const resultBox = document.querySelector('.results');
        resultBox.style.display = "block";
    }
  

</script>
</html>