<?php
session_start();
require_once "../config/database.php";


include "nav.php";




$sql = "SELECT * FROM images  ORDER BY date DESC";
if($stmt = $pdo->prepare($sql)){
  $stmt->execute();  
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome to Camagru</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">  
</head>
<body>
    <div id="container" class="gallery">
      <div id="main">
        <div id="gallery">
        <?php
            $result = $stmt->fetchAll();
            foreach ($result as $pic)
            {
              ?>
              <div id='img' class='img'>
              <img src="<?php echo $pic['photo']; ?>"><?php if($_SESSION['loggedin']){?>
                  <button onclick="window.location.href='action.php?id=<?php echo $pic['photo_id']; ?>'">Comment</button>
                  <button id="like">Like</button>
                  <?php } 
                  else{?>
                    <button onclick="alert('You have to login first')">Comment</button>
                    <button id="like" onclick="alert('You have to login first')">Like</button>
                    <?php
                    
                  }
?>
              
               
              </div>  
            <?php }
        ?>
        </div>
        
      </div>       
    </div>



</body>






</html>


