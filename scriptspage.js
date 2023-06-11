
    
    //Script for Stupage and regpage    
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
    //Variables and Functionsa for userdata page
    const genInfo = document.querySelector('.opt1');
    const grades = document.querySelector('.opt2');
    const genInfoDis = document.querySelector('.genInfo');
    const gradesDis = document.querySelector('.grades');
    const editPop = document.querySelector('.edit');
    const delconfirm = document.querySelector('.delete-confirm');
    const modGrades = document.querySelector('.modGrades');
    const firstgrading = document.querySelector('.firstgrading');
    const secgrading = document.querySelector('.secgrading');
    const thridgrading = document.querySelector('.thridgrading');
    const fourthgrading = document.querySelector('.fourthgrading');
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
    function showEdit(){
        editPop.showModal();
    }
    function closeEdit(){
        editPop.close();
    }
    function openDel(){
        delconfirm.showModal();
    }
    function cancDel(){
        delconfirm.close();
    }
    function openModG(){
        modGrades.showModal();
    }
    function cancelMod(){
        modGrades.close();
    }
    function openFirst(){
        
        firstgrading.showModal();

    }
    function closeFirst(){
        firstgrading.close();
    }
    function openSecond(){
        
        secgrading.showModal();
        
    }
    function closeSec(){
        secgrading.close();
    }
    function openThird(){
        
        thridgrading.showModal();
        
    }
    function closeThird(){
        
        thridgrading.close();
        
    }
    
    function openFourth(){
        
        fourthgrading.showModal();
        
    }
    function closeFourth(){
        
        fourthgrading.close();
        
    }
    