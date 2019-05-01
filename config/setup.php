<?php

include "database.php";

$pdo = new PDO("mysql:host=nr84dudlpkazpylz.chr7pe7iynqr.eu-west-1.rds.amazonaws.com:3306", $DB_USER, $DB_PASSWORD);
$sql = file_get_contents('camagru.sql');
$qr = $pdo->exec($sql);
header("location: ../index.php");




?>
