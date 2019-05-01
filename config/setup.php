<?php

include "database.php";

$pdo = new PDO('mysql://r27geybatkim6x9g:goau3mbk301t8zqs@nr84dudlpkazpylz.chr7pe7iynqr.eu-west-1.rds.amazonaws.com:3306/wktjmhfmeq80m9nj');
$sql = file_get_contents('camagru.sql');
$qr = $pdo->exec($sql);
header("location: ../index.php");




?>
