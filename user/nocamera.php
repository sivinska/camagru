<?php
session_start();

include"nav.php";
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
</head>


<body>
<div id="container" class="gallery">  
<div id="main">
<div class="wrapper1">
  <header>Create your image!</header>
  <article>
            <form method="post" enctype="multipart/form-data">
            <input type="file" id="imageLoader" name="files[]"/>
            </form>

    <div id="webcam">
            
           
            <div><img  id="overlay">
            <canvas id="canvas_img"></canvas></div>
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

                       
           


                <canvas id="canvas" width="300" height="300"></canvas>
                 </footer>
                
                 
            </div>
        </div>
        
        <script src="photo.js"></script>
        
        
        		</div>	
        </div>



</body>
    
 

  