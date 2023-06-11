<?php
// Include Connection Function
include 'credentials.php';

try {
    $pdo = connect();
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if (isset($_GET['query'])) {
        $query = $_GET['query'];
        $searchSQL = "SELECT * FROM tblstudents WHERE CONCAT(FirstName,' ', LastName) LIKE :query OR LRN = :lrn";
        $stmt = $pdo->prepare($searchSQL);
        $stmt->bindValue(':query', '%' . $query . '%');
        $stmt->bindValue(':lrn', $query);
        $stmt->execute();
        $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        
        // Return the search results as JSON
        echo json_encode($searchResults);
    }
} catch (PDOException $e) {
    // Display an error message if unable to connect to the database
    echo "Connection failed: " . $e->getMessage();
}
$pdo = null;
?>
