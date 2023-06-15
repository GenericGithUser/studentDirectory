  <?php
  include 'credentials.php';
  include './redirect.php';
  $LRN = $_GET['LRN'];
                     $pdo = connect();
                    if(isset($_POST['submit'])){
                        $sqlDelFor = "DELETE FROM grades WHERE LRN= :LRN";
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