<?php
session_start();
require_once "../config/database.php";
include "nav.php";

if(!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"] === true){
  header("location: login.php");
  exit;
}

$sql = "SELECT * FROM images WHERE username = :username ORDER BY date DESC LIMIT 7";

if($stmt = $pdo->prepare($sql)){
  $stmt->bindParam("username", $_SESSION['username'], PDO::PARAM_STR);
  $stmt->execute();  

}
?>





<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Camera</title>
  <link rel="stylesheet" href="style.css">  
</head>


<body>

<div id="container" class="gallery">  
<div id="main">
<div class="wrapper1">
  <header>Create your image!</header>
  <article>
    <div id="webcam">
           <div><img id="overlay"></div>
          <video id="video"></video>
      </div>
  </article> 
  <aside>
    <div id="choose_masks">
      <div id='img_mask' class='img_mask'><img src="../images/arrow1080x.png" class="mask active" width="100%"></div>
      <div id='img_mask' class='img_mask'><img src="../images/wolfoverlay.png" class="mask" width="100%"></div>
      <div id='img_mask' class='img_mask'><img src="../images/trianglepaintswash.png" class="mask" width="100%"></div>
      <div id='img_mask' class='img_mask'><img src="../images/circlestreak.png" class="mask" width="100%"></div>
      <div id='img_mask' class='img_mask'><img src="../images/smoketexturepng2.png" class="mask" width="100%"></div>
      <div id='img_mask' class='img_mask'><img src="../images/octogon.png" class="mask" width="100%"></div>
          </div>
          <div class="button-container">     
            <button class="button" id="startbutton">Take a pic</button></div>
            <div class="button-container"> 
            <button action="save_image.php" class="button" id="save">Save it</button>
          </div>
  </aside>
  <footer>
  <div>
  <p class="pstyle">Don't have a camera? What to upload an image from your library? <a href="nocamera.php">Click here.</a></span>
  </div>
  <br /><br />
 
      <canvas id="canvas" width="300" height="300"></canvas>
      <?php
            $result = $stmt->fetchAll();
            foreach ($result as $pic)
            {
              echo"
              <img src='".$pic['photo']."'>";
            }
        ?>
                 </footer>
            </div>
        </div>
        
        
        <script src="new.js"></script>
       		</div>	
        </div>



</body>
    
 

  