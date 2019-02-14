<?php
session_start();
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
</head>


<body>

<div id="container" class="gallery">  

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
      <div id='img_mask' class='img_mask'><img src="../images/whitesmoke.11.png" class="mask" width="100%"></div>
      <div id='img_mask' class='img_mask'><img src="../images/wolfoverlay.png" class="mask" width="100%"></div>
      <div id='img_mask' class='img_mask'><img src="../images/trianglepaintswash.png" class="mask" width="100%"></div>
      <div id='img_mask' class='img_mask'><img src="../images/circlestreak.png" class="mask" width="100%"></div>
      <div id='img_mask' class='img_mask'><img src="../images/ponygirl.png" class="mask" width="100%"></div>
      <div id='img_mask' class='img_mask'><img src="../images/smoketexturepng2.png" class="mask" width="100%"></div>
      <div id='img_mask' class='img_mask'><img src="../images/octogon.png" class="mask" width="100%"></div>
          </div>     
            <button class="button" id="startbutton">Take a pic</button>
            <button action="save_image.php" class="button" id="save">Save it</button>
          
  </aside>
  <footer>Footer

                       
           


                <canvas id="canvas" width="300" height="300"></canvas>
                 </footer>
            </div>
        </div>
        
        
        <script src="new.js"></script>
       		</div>	
        </div>



</body>
    
 

  