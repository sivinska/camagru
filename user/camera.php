<?php
session_start();
require_once "../config/database.php";
include "nav.php";

if(!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"] === true){
  header("location: login.php");
  exit;
}


?>





<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Camera</title>
  <link rel="stylesheet" href="style.css">  
  <link href="https://fonts.googleapis.com/css?family=Lora:400,700i" rel="stylesheet">

</head>


<body>

<div id="container" class="gallery"> 
  <div id="main"> 
<div class="wrapper1">
  <aside>
    <div id="webcam">
           <div><img src="../images/circlestreak.png" id="overlay"></div>
          <div class="crop"><video id="video" ></video></div>
    </div>
  </aside> 
  <article>
    <div id="choose_masks" class="top">
      <div id='img_mask' class='img_mask'><img src="../images/arrow1080x.png" class="mask active" width="100%"></div>
      <div id='img_mask' class='img_mask'><img src="../images/wolfoverlay.png" class="mask" width="100%"></div>
      <div id='img_mask' class='img_mask'><img src="../images/trianglepaintswash.png" class="mask" width="100%"></div>
      <div id='img_mask' class='img_mask'><img src="../images/circlestreak.png" class="mask" width="100%"></div>
      <div id='img_mask' class='img_mask'><img src="../images/smoketexturepng2.png" class="mask" width="100%"></div>
      <div id='img_mask' class='img_mask'><img src="../images/octogon.png" class="mask" width="100%"></div>
          </div>
            <div class="button-container"> 
            <button action="save_image.php" class="button" id="save" onClick="window.location.reload()" >Save it</button>
          </div>
</article>
  <footer>
  <div>
  <p class="pstyle">Don't have a camera? Want to upload an image from your library? <a href="nocamera.php">Click here.</a></span>
  </div>
  <br /><br />
 
      <canvas id="canvas"></canvas>
      <div id="thumbnails">
      <?php
            $sql = "SELECT * FROM images WHERE user_id = :user_id ORDER BY date DESC";

            if($stmt = $pdo->prepare($sql)){
              $stmt->bindParam("user_id", $_SESSION['user_id'], PDO::PARAM_STR);
              $stmt->execute();  


            $result = $stmt->fetchAll();
            foreach ($result as $pic)
            {
              echo"
              <img border='3px solid #7F7F7F'  width='200' height='200' src='".$pic['photo']."'>";
            }
          }
        ?>
        </div>
                 </footer>
            </div>
        </div>
        
        
        <script src="new.js"></script>
     
       		</div>	
        </div>



</body>
    
 

  