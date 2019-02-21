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
</head>


<body>

<div id="container" class="gallery">  
<div id="main">
<div class="wrapper2">
    <header>Your profile!</header>
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
    
        var newName = this.id;
        alert(newName);
        ajax(newName);        
    };

  }

function ajax(newName){
  xhr = new XMLHttpRequest();
  // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
      if (this.status === 200 && this.readyState == 4 ) {
         // alert('Something went wrong.  Name is now ' + this.responseText);
      }
      // else if (this.status !== 200) {
      //     alert('Request failed.  Returned status of ' + this.status);
      // }
  };
  xhr.open('GET', `delete.php?name=${newName}&other=toto`, true);
  // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.send(newName);
}

</script>

