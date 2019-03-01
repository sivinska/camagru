<?php

require_once "../config/database.php";
session_start();


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

$photo_id = $_GET['photo_id'];


var_dump($_SESSION['user_id']);
var_dump($_GET['photo_id']);
var_dump(($_POST["comment"]));


if(test_input($_POST["add"]) === "add"){
  if(empty(test_input($_POST["comment"]))){
    $comment_err = "Comment cannot be empty.";
} else{
    $comment = test_input($_POST["comment"]);
}
}
  
 







            $sql = "SELECT * FROM images WHERE photo_id = :photo_id ";

            if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam("photo_id", $_GET['photo_id'], PDO::PARAM_STR);
            $stmt->execute();
          
            } 
            $result = $stmt->fetchAll();
            foreach ($result as $pic){
                echo"
              <img src='".$pic['photo']."'>";
            }
          











?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
        <form method="post" id="com">
			<table class="table">
            
				<tr></tr>
				
				<tr>
					<td id=""><b>Add</b></td>
					<td></td>
					<td><input id="test" type="comment" placeholder="Your comment here." value="<?php echo $comment; ?>"></td>


					<td><button id="myButton" type='submit' name="add" value="add" class="btn btn-primary">Add</button></td>
				</tr>
			</table>
		</form>
		<br /><br /><br /><br /><br /><br />
<script>

var photo_id = <?= $photo_id ?> 

var message = document.getElementById("test");
document.getElementById("myButton").addEventListener("click", function() {
  if (message.value.trim().length == 0) {
        alert('comment must not be empty');
        return;
  }

var request = new XMLHttpRequest();
request.open('POST', 'action.php', true);
request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
console.log(request.send(message.value));



});





</script>


