<?php

$DB_DSN = 'mysql:host=nr84dudlpkazpylz.chr7pe7iynqr.eu-west-1.rds.amazonaws.com:3306; dbname=wktjmhfmeq80m9nj';
$DB_USER = 'r27geybatkim6x9g';
$DB_PASSWORD = "goau3mbk301t8zqs";

 
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
