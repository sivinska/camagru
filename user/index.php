<?php

session_start();
require_once "../config/database.php";
include "nav.php";
$sql = "SELECT * FROM image_uploads";
if($stmt = $pdo->prepare($sql)){
  $stmt->execute();  
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome to Camagru</title>
  <link rel="stylesheet" href="style.css">  
</head>
<body>
    <div id="container" class="gallery">
      <div id="main">
        <div id="gallery">
        <?php
            $result = $stmt->fetchAll();
            foreach ($result as $pic)
            {
              echo"<div id='img' class='img'>
              <img src='".$pic['url']."'></div>";
            }
        ?>
        </div>
      </div>       
    </div>
</body>
</html>