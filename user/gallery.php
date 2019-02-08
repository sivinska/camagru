<?php

session_start();

require_once "../config/database.php";

$sql = "SELECT * FROM images ORDER BY date DESC";
if($stmt = $pdo->prepare($sql)){
  $stmt->execute();
  
    
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Gallery</title>
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
  <div id="gallery">
<?php

            $result = $stmt->fetchAll();
            foreach ($result as $pic)
            {
              echo"<div id='img' class='img'>
              <img src='".$pic['photo']."'></div>";
            }
          
?>

</body>
    
 

  