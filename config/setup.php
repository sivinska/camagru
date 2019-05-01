<?php

include "database.php";

$pdo = new PDO("mysql:host=localhost", $DB_USER, $DB_PASSWORD);
$sql = file_get_contents('camagru.sql');
$qr = $pdo->exec($sql);
header("location: ../index.php");




?>