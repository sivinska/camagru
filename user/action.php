<?php
session_start();

require_once "../config/database.php";
include "nav.php";

$photo_id = test_input($_GET['id']);



function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }





if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(test_input($_POST["comment"]))){
        $error = "Please enter words.";
    } else{
        $comment = test_input($_POST["comment"]);
    }

    if(empty($error)){
        $sql = "INSERT INTO comments (user_id, username, photo_id, comment) VALUES (:user_id, :username, :photo_id, :comment)";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":user_id", $_SESSION['user_id'], PDO::PARAM_STR);
            $stmt->bindParam(":username", $_SESSION['username'], PDO::PARAM_STR);
            $stmt->bindParam(":photo_id", $photo_id, PDO::PARAM_STR);
            $stmt->bindParam(":comment", $comment, PDO::PARAM_STR);
            $stmt->execute();

            }
    
            


}
     
	
}

?>


<!DOCTYPE html>
<html>
	<head>
    <title>Comments</title>

		<meta charset="utf-8">
        <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">  
	</head>
	<body>
    <div id="container" class="gallery">
        <div id="main">
          <div class="modal-wrap">
      <article>
    <?php  $sql = "SELECT * FROM images WHERE photo_id = :photo_id ";

if($stmt = $pdo->prepare($sql)){
$stmt->bindParam("photo_id", $photo_id, PDO::PARAM_STR);
$stmt->execute(); 
$result = $stmt->fetchAll();
foreach ($result as $pic){
    echo"
  <img src='".$pic['photo']."'>";
}
}?></article><aside>
<table class="table">


    <?php 

$sql = "SELECT * FROM comments WHERE photo_id = :photo_id";
            if($stmt = $pdo->prepare($sql)){
                $stmt->bindParam("photo_id", $photo_id, PDO::PARAM_STR);
                $stmt->execute(); 
                $result = $stmt->fetchAll();
                foreach ($result as $pic){
                    echo"<tr>
                        <th>".$pic['username']."</th>
                        <td>".$pic['comment']."</td>
                        </tr>";
                }
                }

    ?>
    
        <form action="action.php?id=<?php echo test_input($pic['photo_id']); ?>"  method="post">
				<tr>
					<td>Comment</td>
					<td><input type="comment" name="comment" placeholder="Your comment here." value=""></td>
                    <td><button>Submit</button></td>

				</tr>
			
		</form></table></aside>