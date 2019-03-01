<?php
session_start();

require_once "../config/database.php";


$photo_id = $_GET['id'];



function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

/*$sql = "SELECT * FROM comments WHERE photo_id = :photo_id";
if($stmt = $pdo->prepare($sql)){
    $stmt->bindParam("photo_id", $photo_id, PDO::PARAM_STR);
    $stmt->execute(); 
    $result = $stmt->fetchAll();
    foreach ($result as $pic){
        echo"<div><p>".$pic['username']."</p>
        </div>
        <div><p>".$pic['comment']."</p></div>";
    }
    }*/

$sql = "SELECT * FROM images WHERE photo_id = :photo_id ";

if($stmt = $pdo->prepare($sql)){
$stmt->bindParam("photo_id", $photo_id, PDO::PARAM_STR);
$stmt->execute(); 
$result = $stmt->fetchAll();
foreach ($result as $pic){
    echo"
  <img src='".$pic['photo']."'>";
}
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
		<meta charset="utf-8">
	</head>
	<body>

    <?php 

$sql = "SELECT * FROM comments WHERE photo_id = :photo_id";
            if($stmt = $pdo->prepare($sql)){
                $stmt->bindParam("photo_id", $photo_id, PDO::PARAM_STR);
                $stmt->execute(); 
                $result = $stmt->fetchAll();
                foreach ($result as $pic){
                    echo"<div><p>".$pic['username']."</p>
                    </div>
                    <div><p>".$pic['comment']."</p></div>";
                }
                }

    ?>
        <form action="action.php?id=<?php echo $pic['photo_id']; ?>"  method="post">
			<table class="table">
            
				<tr></tr>
				
				<tr>
					<td><b>Comment</b></td>
					<td></td>
					<td><input type="comment" name="comment" placeholder="Your comment here." value=""></td>
					<td><button>Submit</button></td>
				</tr>
			</table>
		</form>