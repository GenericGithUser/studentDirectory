<?php
function connect(){
    $dbname = "dbstudentdirectory";
    $username = "root";
    $password = "";
    $host = "localhost";
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    return $pdo;
}
?>