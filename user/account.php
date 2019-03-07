<?php

session_start();
require_once "../config/database.php";
include "nav.php";

if(!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"] === true){
  header("location: login.php");
  exit;
}
$sql = "SELECT * FROM images WHERE user_id = :user_id ORDER BY date DESC";

  if($stmt = $pdo->prepare($sql)){
    $stmt->bindParam("user_id", $_SESSION['user_id'], PDO::PARAM_STR);
    

    $stmt->execute();  


  }

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Camera</title>
  <link rel="stylesheet" href="style.css">  
  <link href="https://fonts.googleapis.com/css?family=Lora:400,700i" rel="stylesheet">

</head>


<body>

<div id="container" class="gallery">  
<div id="main">
<div class="wrapper2">
    <aside>
    <table>
    <tr class="pointer" onclick="window.location.href='usermail.php'"><td>
    Email and username
    </td></tr>
    <tr class="pointer" onclick="window.location.href='modpw.php'"><td>
    Password
    </td></tr>
    <tr class="pointer" onclick="window.location.href='delphoto.php'"><td>
    Delete photos
    </td></tr>








    </table>
        
    </aside>
    <article>
        <h3> <?php echo $_SESSION['username']; ?> </h3>
        <div id="gallery">
        <?php
            $result = $stmt->fetchAll();
            foreach ($result as $pic)
            {
              echo"<div id='img' class='img'>
              <img src='".$pic['photo']."'></div>";
            }
        ?>
        </div>
    </article>

</div>
</div>
<div class="wrapper-foot">
    sivinska &copy; - Camagru - 2019
</div>
