<?php
require_once "../config/database.php";
session_start();

include "nav.php";
$sql = "SELECT * FROM images ORDER BY date DESC";
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
              <span class='span1'>".$pic['username']."</span>
              <img src='".$pic['photo']."'>
              </div>";
            }
        ?>
        </div>
      </div>       
    </div>
</body>
</html>


