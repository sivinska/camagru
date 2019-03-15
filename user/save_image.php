<?php
session_start();
require_once "../config/database.php";

if (isset($_SESSION['loggedin']) && $_SESSION["loggedin"] === true){
    $sql = "SELECT * users WHERE username = :username";
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam("username", $_SESSION['username'], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $user_id = $result[0]['user_id'];
    }
    
    
}

//get properly base64 image data passed via post in 'cnvimg'

$cnvimg = $_POST['cnvimg'];
$mask = $_POST['mask'];

$cnvimg = str_replace('data:image/png;base64,', '', $cnvimg);
$cnvimg = str_replace(' ', '+', $cnvimg);
$data = base64_decode($cnvimg);
$target_dir = "../uploads/".$_SESSION['user_id']."/";
if (!file_exists($target_dir))
        mkdir($target_dir, 0777, true);

$file = $target_dir . mktime() .'.png'; 
file_put_contents($file, $data);


           
            
           
$imgcpy = imagecreatefrompng($file);
$maskcpy = imagecreatefrompng($mask);

$resized_mask = imagecreatetruecolor(300, 300);
imagealphablending($resized_mask, false);

imagealphablending($maskcpy, true);
imagesavealpha($maskcpy, true);
$src_x = imagesx($maskcpy);
$src_y = imagesy($maskcpy);
imagecopyresized($resized_mask, $maskcpy, 0, 0, 0, 0, 300, 300, $src_x, $src_y);
imagecopy($imgcpy, $resized_mask, 0, 0, 0, 0, $src_x, $src_y);
imagepng($imgcpy, $file);






$sql = "INSERT INTO images (user_id, username, photo, likes, com) VALUES (:user_id, :username, :photo, :likes, :com)";

if ($stmt = $pdo->prepare($sql)){
    $stmt->bindParam(":username", $_SESSION['username'], PDO::PARAM_STR);
    $stmt->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(":photo", $file, PDO::PARAM_STR);
    $stmt->bindParam(":likes", $likes , PDO::PARAM_INT);
    $stmt->bindParam(":com", $com , PDO::PARAM_INT);
    $likes = '0';
    $com = '0';
    $stmt->execute();    
}


?>