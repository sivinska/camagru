<?php

session_start();
require_once "../config/database.php";
if(!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"] === true){
    header("location: login.php");
    exit;
  }

$photo_id = $_GET['name'];

$sql = "DELETE FROM images WHERE photo_id= :photo_id";
if ($stmt = $pdo->prepare($sql)){
    $stmt->bindParam("photo_id", $photo_id);
    if($stmt->execute()){
        header ("location: delphoto.php");
        }
}   
?>