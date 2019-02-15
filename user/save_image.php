<?php

require_once "../config/database.php";
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION["loggedin"] === true){
    $profile = $_SESSION['username'];
}

//get properly base64 image data passed via post in 'cnvimg'
$cnvimg = trim(strip_tags($_POST['cnvimg']));
$cnvimg = str_replace('data:image/png;base64,', '', $cnvimg);
$cnvimg = str_replace(' ', '+', $cnvimg);

//set image name from 'imgname', or unique name set with uniqid()
$imgname = trim(strip_tags($_POST['imgname']));
//get image data from base64 and save it on server
$data = base64_decode($cnvimg);
$target_dir = "uploads/".$_SESSION['username']."/";
if (!file_exists($target_dir))
        mkdir($target_dir, 0777, true);

$file = $target_dir . mktime() .'.png'; 
$success = file_put_contents($file, $data);

$sql = "INSERT INTO images (username, photo) VALUES (:username, :photo)";

if ($stmt = $pdo->prepare($sql)){
    $stmt->bindParam("username", $_SESSION['username'], PDO::PARAM_STR);
    $stmt->bindParam("photo", $file, PDO::PARAM_STR);

    $stmt->execute();    
}

//output response (link to image file, or error message)
//print $success ? 'Image: <a href="'. $file .'" target="_blank">'. $file .'</a>' : 'Unable to save the file.';

?>