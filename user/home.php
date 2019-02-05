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
<div class="container-login100" class="bgded overlay" style="background-image: url('https://images.unsplash.com/photo-1513652990199-8a52e2313122?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1650&q=80');">
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

<div>
<video id="video" width="640" height="480" autoplay></video>
<button id="snap">Snap Photo</button>
<canvas id="canvas" width="640" height="480"></canvas>
</div>

    
    <script src="cam.js"></script>

  