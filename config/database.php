<?php

$DB_DSN = 'mysql:host=localhost; dbname=camagru';
$DB_USER = 'root';
$DB_PASSWORD = "Katinukas";

 
/* Attempt to connect to MySQL database */
try{
    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    $pdo = null;
    // die("ERROR: Could not connect. " . $e->getMessage());
}



?>
