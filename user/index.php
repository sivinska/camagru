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
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">  
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
              <img src='".$pic['photo']."'>
              </div>";
            }
        ?>
        </div>
      </div>       
    </div>
</body>
</html>


