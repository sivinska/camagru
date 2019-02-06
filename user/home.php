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
      <a href="#">Gallery</a>
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



		<div class="content">
			            
        <div id="div_use_webcam">
            <h1 class="cam_titles">Create your image !</h1>
            <p class="button_p">
                               
                <input id="snap" type="button" value="Snapshot" class="webcam-button">
            </p>
            <div id="live_div">
                <div><img src="" id="overlay"></div>
                <video id="videoElement" class="video-circle"></video>
            </div>
            <div id="div_choose_trees">
                <img src="../images/circle.png" class="i_trees active" width="25%">
                <img src="../images/whitesmoke.11.png" class="i_trees" width="25%">
                <img src="../images/wolfoverlay.png" class="i_trees" width="25%">
                <img src="../images/trianglepaintswash.png" class="i_trees" width="25%">
            </div>
        </div>
        <div id="mini_box">
            <h1 class="cam_titles">History</h1>
            <div id="mini">
                        </div>
        </div>
        <div id="modal_result">
            <div id="div_final_result">
                <h1 class="cam_titles">Happy with this picture ?</h1>
                <canvas id="canvas" width="640" height="480"></canvas>
                <form method="POST" action="" onsubmit="createImg();">
                        <input id="inp_img" name="img" type="hidden" value="">
                        <input id="tree" name="tree" type="hidden" value="">
                        <input id="filter" name="filter" type="hidden" value="none">
                        <input id="upload" class="webcam-button" type="Submit" value="Upload" disabled="true">
                </form>
            </div>
        </div>
        <p class="text">No webcam? You can upload your own photo <a href="?action=upload" class="textlink">here</a></p>
        <canvas id="canvas_copy" width="640" height="480"></canvas>
        <canvas id="canvas_tree" width="300" height="300"></canvas>
        <form method="POST" action="" id="photo_delete">
            <input id="id_photo_delete" name="id_photo_delete" type="hidden" value="">
        </form>
        <script src="cam.js"></script>		</div>	
	



</body>
    
 

  