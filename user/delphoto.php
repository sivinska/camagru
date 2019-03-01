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
  <title>Delete your photos</title>
  <link rel="stylesheet" href="style.css">  
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">  

</head>


<body>

<div id="container" class="gallery">  
<div class="wrapper2">
    <aside>
        <form action="usermail.php" method="post">
			<button type="submit" class="button">Email and Username</button>
        </form>
        <form action="modpw.php" method="post">
			<button type="submit" class="button">Password</button>
        </form>
        <form action="delphoto.php" method="post">
			<button type="submit" class="button">Photos</button>
		</form>
    </aside>
    <article>
        <h3> <?php echo $_SESSION['username']; ?> </h3>
        <div id="gallery">
        <?php
            $sql = "SELECT * FROM images WHERE user_id = :user_id ORDER BY date DESC";

            if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam("user_id", $_SESSION['user_id'], PDO::PARAM_STR);
            $stmt->execute();
          
            } 
            $result = $stmt->fetchAll();
            foreach ($result as $pic)
            {
             
              echo"<form action='delete.php' method='post'><div id='img' class='img'>
              <img src='".$pic['photo']."'>
              <button id ='".$pic['photo_id']."'>Delete this image</button></form>
              </div>";
            }
            
          
        ?>
        </div>
    </article>
    </body>
<script>
var buttons = document.getElementsByTagName("button");
var buttonsCount = buttons.length;
for (var i = 0; i < buttonsCount; i++) {
    buttons[i].onclick = function(e) {
        var photo_id = this.id;
        (ajax(photo_id));        
    };

  }

function ajax(photo_id){
  xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
      if (this.status === 200 && this.readyState == 4 ) {
      }
  };
  xhr.open('GET', `delete.php?name=${photo_id}`, true);
  xhr.send(photo_id);
}

</script>

