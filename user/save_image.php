<?php
define('UPLOAD_DIR', 'uploads/');  //Upload folder
require_once "../config/database.php";


//get properly base64 image data passed via post in 'cnvimg'
$cnvimg = trim(strip_tags($_POST['cnvimg']));
$cnvimg = str_replace('data:image/png;base64,', '', $cnvimg);
$cnvimg = str_replace(' ', '+', $cnvimg);

//set image name from 'imgname', or unique name set with uniqid()
$imgname = trim(strip_tags($_POST['imgname']));
//get image data from base64 and save it on server
$data = base64_decode($cnvimg);
$file = UPLOAD_DIR . mktime() .'.png'; 
$success = file_put_contents($file, $data);

$sql = "INSERT INTO image_uploads (url) VALUE (:url)";

if ($stmt = $pdo->prepare($sql)){
    $stmt->bindParam("url", $file, PDO::PARAM_STR);
    $stmt->execute();    
}

//output response (link to image file, or error message)
//print $success ? 'Image: <a href="'. $file .'" target="_blank">'. $file .'</a>' : 'Unable to save the file.';

?>