<?php
session_start();




?>





<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Create an account</title>
  <link rel="stylesheet" href="style.css">  
</head>


<body>
<div class="container-camera" class="bgded overlay" style="background-image: url('https://images.unsplash.com/photo-1519636243899-5544aa477f70?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80');">
      <div class="wrapper row1">
    <nav>
  <ul>
    <li>
    <?php
		  	if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
              {
                  echo '<a href="home.php">Home</a>';
              }
              else
              {
                  echo '<a href="indexpage.php">Home</a>';
              }
		?>
    </li>
    <li>
      <a href="gallery.php">Gallery</a>
    </li>
    <li>
      <a href="#">Your account</a>
    </li>
    <li>
    <?php
		  	if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
              {
                  echo '<a href="logout.php">Logout</a>';
              }
            else{
                echo '';
            }
		?>
    </li>
  </ul>
    </nav>
    </div>


    <div id="main">
      <div class="section">    
        <h1>Create your image !</h1>
            <form method="post" enctype="multipart/form-data">
            <input type="file" id="imageLoader" name="files[]"/>
            
        </form>
        <div id="webcam">
           
            <div><img  id="overlay">
           
            <canvas id="canvas_img"></canvas></div>
      </div>
          </div>
      <div class="aside">        
            <div id="choose_masks">
                <img src="../images/arrow1080x.png" class="mask active" width="20%">
                <img src="../images/whitesmoke.11.png" class="mask" width="20%">
                <img src="../images/wolfoverlay.png" class="mask" width="20%">
                <img src="../images/trianglepaintswash.png" class="mask" width="20%">
                <img src="../images/circlestreak.png" class="mask" width="20%">
                <img src="../images/ponygirl.png" class="mask" width="20%">
                <img src="../images/smoketexturepng2.png" class="mask" width="20%">
                <img src="../images/octogon.png" class="mask" width="20%">
            </div>
            <button class="login100-form-btn" id="startbutton">Take a pic</button>
            <button action="save_image.php" class="login100-form-btn" id="save">Save it</button>
          </div>
        <div class="footer">
           
        
                           
        
       
        <canvas id="canvas" width="300" height="300"></canvas></div>
              
          
                


                
                 
            </div>
        </div>
        
        <script src="photo.js"></script>
        
        
        		</div>	
        </div>



</body>
    
 

  