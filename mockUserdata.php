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
        <p><a href="page.php"><img src="img/logout.png" class="logout">Go Back?</a></p>
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
            <div class="genInfo">
                aa
            </div>
            <div class="grades">
                75
            </div>
        </div>
    </div>
</body>
<script>
        const genInfo = document.querySelector('.opt1');
        const grades = document.querySelector('.opt2');
        const genInfoDis = document.querySelector('.genInfo');
        const gradesDis = document.querySelector('.grades');
        function switcheri(){
            genInfo.classList.remove("active");
            grades.classList.add("active");
            genInfoDis.style.display="none";
            gradesDis.style.display="block";
        }
        function switcherii(){
            genInfo.classList.add("active");
            grades.classList.remove("active");
            genInfoDis.style.display="block";
            gradesDis.style.display="none";
        }
    
</script>
</html>