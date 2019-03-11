<?php 

session_start();
require_once "../config/database.php";

$user_id = $_SESSION['user_id'];




$sql = "SELECT * FROM users WHERE user_id =:user_id";
if ($stmt = $pdo->prepare($sql)){
  $stmt->bindParam(":user_id", $_SESSION['user_id']);

  $stmt->execute();
  $all = $stmt->fetchAll();
  var_dump($all[0]['notification']);
  $result = $stmt->rowCount();
  if ($result > 0){
    if ($all[0]['notification'] === 'yes'){
        $sql = "UPDATE users SET notification =:notification WHERE user_id = :user_id";
        if ($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":notification", $notif);
            $notif = 'no';
            if ($stmt->execute()){
            header ("location: usermail.php");
            }
        }
    }
    else if ($all[0]['notification'] === 'no'){
        $sql = "UPDATE users SET notification =:notification WHERE user_id = :user_id";
        if ($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":notification", $notif);
            $notif = 'yes';
            if ($stmt->execute()){
                header ("location: usermail.php");
                }

        }
    }



  }
}