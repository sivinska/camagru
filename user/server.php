<?php 

session_start();
require_once "../config/database.php";

$photo_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM likes WHERE user_id =:user_id AND photo_id= :photo_id";
if ($stmt = $pdo->prepare($sql)){
  $stmt->bindParam(":user_id", $_SESSION['user_id']);
  $stmt->bindParam(":photo_id", $photo_id);

  $stmt->execute();
  $result = $stmt->rowCount();
  if ($result > 0){
    $sql = "DELETE FROM likes WHERE user_id =:user_id AND photo_id= :photo_id";
    if ($stmt = $pdo->prepare($sql)){
      $stmt->bindParam(":user_id", $_SESSION['user_id']);
      $stmt->bindParam(":photo_id", $photo_id);
    
      if ($stmt->execute()){
          $sql = "UPDATE images SET likes = likes - 1 WHERE photo_id = :photo_id";
    if ($stmt = $pdo->prepare($sql)){
      $stmt->bindParam(":photo_id", $photo_id);
      $stmt->execute();
    }
      }
      header("location: index.php");
  }
}
  else{
$sql="INSERT INTO likes (user_id, photo_id) VALUES (:user_id, :photo_id)";
if ($stmt = $pdo->prepare($sql)){
    $stmt->bindParam(":user_id", $_SESSION['user_id']);
    $stmt->bindParam(":photo_id", $photo_id);


    if ($stmt->execute()){
      $sql = "UPDATE images SET likes = likes + 1 WHERE photo_id = :photo_id";
if ($stmt = $pdo->prepare($sql)){
  $stmt->bindParam(":photo_id", $photo_id);
  $stmt->execute();
}
    }
    header("location: index.php");
  }

}
}

