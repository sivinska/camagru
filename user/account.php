<?php
session_start();
include "nav.php";
require_once "../config/database.php";


if(!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"] === true){
    header("location: login.php");
    exit;
}
$sql = "SELECT * FROM images WHERE username = :username ORDER BY date DESC";

  if($stmt = $pdo->prepare($sql)){
    $stmt->bindParam("username", $_SESSION['username'], PDO::PARAM_STR);
    

    $stmt->execute();  


  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Your account</title>
  <link rel="stylesheet" href="style.css">  
</head>
<body>
    <div id="container" class="gallery">
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
        </div>
      </div>       
    </div>
</body>
</html>