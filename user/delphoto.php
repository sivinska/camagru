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
  <link rel="stylesheet" href="../style/style.css">  
  <link href="https://fonts.googleapis.com/css?family=Lora:400,700i" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<body>
<div id="container" class="gallery"> 
    <div id="main">
        <div class="wrapper2">
            <aside>
                <table class="table">
                    <tr class="pointer" onclick="window.location.href='usermail.php'"><td>
                    Modify your email and username
                    </td></tr>
                    <tr class="pointer" onclick="window.location.href='modpw.php'"><td>
                    Change your password
                    </td></tr>
                    <tr class="pointer" onclick="window.location.href='delphoto.php'"><td>
                    Delete photos
                    </td></tr>
                </table>
            </aside>
            <article>
                <div class="center"><h1><?php echo $_SESSION['username']; ?> </h1></div>
                    <div id="gallery">
                    <?php
                        $sql = "SELECT * FROM images WHERE user_id = :user_id ORDER BY date DESC";

                        if($stmt = $pdo->prepare($sql)){
                        $stmt->bindParam("user_id", $_SESSION['user_id'], PDO::PARAM_STR);
                        $stmt->execute();
                        $result = $stmt->fetchAll();
                        foreach ($result as $pic)
                        {?>

                        <form action='delete.php' method='post'>
                        <div id='img2'>
                            <img class='img2' src="<?php echo $pic['photo']; ?>">
                                <div class="padding" > <?php echo $pic['likes']; ?>
                                <i class="far fa-heart fa-2x"></i>
                                <?php echo $pic['com']; ?>
                                <i class="far fa-comments fa-2x"></i>
                                </div>
                            <button class=" btn1 first" id="<?php echo $pic['photo_id'] ?>">Delete this image</button>
                        </div>
                        </form>
                        
                        <?php
                    }}
                    ?>
                    </div>
            </article>
        </div>
    </div>
<div class="wrapper-foot">
    sivinska &copy; - Camagru - 2019
</div>

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
</body>
</html>

