<?php

session_start();
require_once "../config/database.php";
include "nav.php";

if(!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"] === true){
  header("location: login.php");
  exit;
}



if (isset($_POST['liked'])) {
    
    $photo_id = $_POST['photo_id'];
    $sql = "SELECT * FROM images WHERE photo_id = :photo_id";
    if ($stmt = $pdo->prepare($sql)){
        $stmt->bindParam("photo_id", $photo_id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $n = $result['likes'];
    }
    $sql = "INSERT INTO likes (user_id, photo_id, status) VALUES (:user_id, :photo_id, :status)";
    if ($stmt = $pdo->prepare($sql)){
        $stmt->bindParam("user_id", $_SESSION['user_id']);
        $stmt->bindParam("photo_id", $photo_id);
        $stmt->bindParam("status", 'not seen');
        $stmt->execute();

    }

    $sql = "UPDATE images SET likes = :likes WHERE photo_id = :photo_id";
    if ($stmt = $pdo->prepare($sql)){
        $stmt->bindParam("likes", $n+1);
        $stmt->bindParam("photo_id", $photo_id);
        $stmt->execute();
    }
    echo $n+1;
    exit();
}

if (isset($_POST['unliked'])) {
    $photo_id = $_POST['photo_id'];
    $sql = "SELECT * FROM images WHERE photo_id = :photo_id";
    if ($stmt = $pdo->prepare($sql)){
        $stmt->bindParam("photo_id", $photo_id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $n = $result['likes'];
    }

    $sql = "DELETE FROM likes WHERE photo_id = :photo_id AND user_id = :user_id";
    if ($stmt = $pdo->prepare($sql)){
        $stmt->bindParam("user_id", $_SESSION['user_id']);
        $stmt->bindParam("photo_id", $photo_id);
        $stmt->execute();

    }


    mysqli_query($con, "DELETE FROM likes WHERE postid=$postid AND userid=1");

    $sql = "UPDATE images SET likes = :likes WHERE photo_id = :photo_id";
    if ($stmt = $pdo->prepare($sql)){
        $stmt->bindParam("likes", $n-1);
        $stmt->bindParam("photo_id", $photo_id);
        $stmt->execute();
    }
    echo $n-1;
    exit();

}

// Retrieve posts from the database
$sql = "SELECT * FROM images";
if ($stmt = $pdo->prepare($sql)){
    $stmt->execute();
    $result = $stmt->fetchAll();
    $rows = $stmt->rowCount();


?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Like and unlike system</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <style>
    body {
	padding-top: 100px;
}
.post {
	width: 30%;
	margin: 10px auto;
	border: 1px solid #cbcbcb;
	padding: 5px 10px 0px 10px;
}
.like, .unlike, .likes_count {
	color: blue;
}
.hide {
	display: none;
}
.fa-thumbs-up, .fa-thumbs-o-up {
	transform: rotateY(-180deg);
	font-size: 1.3em;
}
    </style>
</head>
<body>
	<!-- display posts gotten from the database  -->
		<?php foreach ($result as $row) {
            {
                echo"<div class='post'>
                <div id='img' class='img'>
                <img src='".$row['photo']."'></div>";
              
                    // determine if user has already liked this post
                    
                    $sql = "SELECT * FROM likes WHERE user_id = :user_id AND photo_id = :photo_id";
                    if ($stmt = $pdo->prepare($sql)){
                        $stmt->bindParam("user_id", $_SESSION['user_id']);
                        $stmt->bindParam("photo_id", $row['photo_id']);
                        $stmt->execute();
                        $rows = $stmt->rowCount();
                        if ($stmt->rowCount() == 1){ ?>

                    

					
						<!-- user already likes post -->
						<span class="unlike fa fa-thumbs-up" data-id="<?php echo $row['photo_id']; ?>"></span> 
						<span class="like hide fa fa-thumbs-o-up" data-id="<?php echo $row['photo_id']; ?>"></span> 
                        <?php } else {?>
						<!-- user has not yet liked post -->
						<span class="like fa fa-thumbs-o-up" data-id="<?php echo $row['photo_id']; ?>"></span> 
						<span class="unlike hide fa fa-thumbs-up" data-id="<?php echo $row['photo_id']; ?>"></span> 
                        <?php } ?>

					<span class="likes_count"><?php echo $row['likes']; ?> likes</span>
				</div>
			</div>
            <?php }}} }?>


<!-- Add Jquery to page -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		// when the user clicks on like
		$('.like').on('click', function(){
			var photo_id = $(this).data('photo_id');
			    $post = $(this);

			$.ajax({
				url: 'likes.php',
				type: 'post',
				data: {
					'liked': 1,
					'photo_id': photo_id
				},
				success: function(response){
					$post.parent().find('span.likes_count').text(response + " likes");
					$post.addClass('hide');
					$post.siblings().removeClass('hide');
				}
			});
		});

		// when the user clicks on unlike
		$('.unlike').on('click', function(){
			var photo_id = $(this).data('photo_id');
		    $post = $(this);

			$.ajax({
				url: 'likes.php',
				type: 'post',
				data: {
					'unliked': 1,
					'photo_id': photo_id
				},
				success: function(response){
					$post.parent().find('span.likes_count').text(response + " likes");
					$post.addClass('hide');
					$post.siblings().removeClass('hide');
				}
			});
		});
	});
</script>
</body>
</html>