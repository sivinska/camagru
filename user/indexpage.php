<?php
session_start();

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome to Camagru</title>
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
      <a href="#">Contact</a>
    </li>
  </ul>
    </nav>
      </div>
      
    <div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
    <span class="login100-form-title p-b-37">Welcome to Camagru!</span>
      <div class="welcome-page-btn">
                <button class="login100-form-btn"><a class="a1" href="register.php">Create an account</a></button>
                </div>
      <div class="welcome-page-btn">
                <button class="login100-form-btn"><a class="a1" href="login.php">Login</a></button>
                </div>
      
  </div>
      
    </div>
</body>
</html>