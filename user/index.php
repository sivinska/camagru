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
              echo"
              <div id='img' class='img'>
              
              <img id ='".$pic['photo_id']."' src='".$pic['photo']."'> 
             <div class='modal'>

               <div class='modal-content'>
                  <span class='close'>&times;</span>
                  <img src='".$pic['photo']."'> 
                  
                </div>

              </div>
              </div>";
            }
        ?>
        </div>
        
      </div>       
    </div>

<script>


var images = document.getElementsByTagName("img");
var imagesCount = images.length;

for (var i = 0; i < imagesCount; i++) {
    images[i].onclick = function(e) {
      this.nextElementSibling.style.display = "block"
    }
}
var modal = document.getElementsByClassName("modal-content");
var modalCount = modal.length;

for (var i = 0; i < modalCount; i++) {
    modal[i].onclick = function(e) {
      this.parentElement.style.display = "none";
    }   
}
    









</script>


</body>






</html>


