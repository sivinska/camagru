<?php
define('UPLOAD_DIR', 'uploads/');  //Upload folder

//get properly base64 image data passed via post in 'cnvimg'
$cnvimg = trim(strip_tags($_POST['cnvimg']));
$cnvimg = str_replace('data:image/png;base64,', '', $cnvimg);
$cnvimg = str_replace(' ', '+', $cnvimg);

//set image name from 'imgname', or unique name set with uniqid()
$imgname = (isset($_POST['imgname']) && !empty(trim($_POST['imgname']))) ? trim(strip_tags($_POST['imgname'])) : uniqid();

//get image data from base64 and save it on server
$data = base64_decode($cnvimg);
$file = UPLOAD_DIR . $imgname .'.png'; 
$success = file_put_contents($file, $data);

//output response (link to image file, or error message)
print $success ? 'Image: <a href="'. $file .'" target="_blank">'. $file .'</a>' : 'Unable to save the file.';

?>