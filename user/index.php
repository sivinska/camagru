<?php
include("nav.php");
session_start();
require_once "../config/database.php";

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
    <div class="container-camera" class="bgded overlay" style="background-image: url('https://images.unsplash.com/photo-1454117096348-e4abbeba002c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80');">
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