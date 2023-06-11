<?php

function connect(){
  // Database credentials
  $hostname = 'localhost';
  $username = 'root';
  $password = '';
  $database = 'dbstudentdirectory';

  try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
  } catch (PDOException $e) {
    // Display an error message if unable to connect to the database
    echo "Connection failed: " . $e->getMessage();
    die();
  }
}

?>
