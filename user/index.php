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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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
              <img src="<?php echo $pic['photo']; ?>">
              <?php if($_SESSION['loggedin']){?>
                  <img src="../images/clipart2124920.png" width="25px" onclick="window.location.href='action.php?id=<?php echo $pic['photo_id']; ?>'">
                 <div> <?php echo $pic['likes']; ?>
                 <img src="../images/clipart882441.png" width="25px" onclick="window.location.href='server.php?id=<?php echo $pic['photo_id']; ?>'">
                 </div> <?php } 
                  else{?>
                    <img src="../images/clipart2124920.png" width="25px" onclick="alert('You have to login first')">
                    <img src="../images/clipart882441.png" width="25px" onclick="alert('You have to login first')">
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


