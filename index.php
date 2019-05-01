<?php
session_start();
include_once "config/database.php";



?>

 



<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome to Camagru</title>
  <link rel="stylesheet" href="style/style.css">
  <link href="https://fonts.googleapis.com/css?family=Lora:400,700i" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>

<body>
  <div id="container" class="gallery">
  <?php
        if (!$pdo){
          ?>
          <div class="install"> 
          <p>To install the database <a href="config/setup.php">click here.</a></p>
          </div>
        <?php
        }
        else 
        
       
        {
   
   include "user/nav.php";
   ?>
   
    <div id="main">
    
      <div id="gallery">
        <?php 
          $page = (!empty($_GET['page']) ? $_GET['page'] : 1);       
          $limit = 9;
          $start = ($page - 1) * $limit;
          $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM images ORDER BY date DESC LIMIT $limit OFFSET $start ";
          if($stmt = $pdo->prepare($sql)){
            $stmt->execute();
            $resultFoundRows = $pdo->query('SELECT found_rows()');
            $nombredElementsTotal = $resultFoundRows->fetchColumn();
            $nombreDePages = ceil($nombredElementsTotal / $limit);
            $result = $stmt->fetchAll();
            foreach ($result as $pic)
            {?>
              <div id='img' class='img'>
              <img src="<?php echo $pic['photo']; ?>">
              <?php if($_SESSION['loggedin']){?>
                <div class="padding" > <?php echo $pic['likes']; ?>
                <i class="far fa-heart fa-2x" onclick="window.location.href='../user/likes.php?id=<?php echo $pic['photo_id']; ?>'"></i>
                <?php echo $pic['com']; ?>
                <i class="far fa-comments fa-2x" onclick="window.location.href='../user/comments.php?id=<?php echo $pic['photo_id']; ?>'"></i>
              </div>
              <?php } 
                else{ ?>
                <div class="padding"> <?php echo $pic['likes']; ?>
                <i class="far fa-heart fa-2x" onclick="alert('You have to login first')"></i>
                <?php echo $pic['com']; ?>
                <i class="far fa-comments fa-2x" onclick="alert('You have to login first')"></i>
                </div>
              <?php } ?>
      </div>   
            <?php }} ?>
    </div>
<div class="center"><?php

if ($page > 1):
      ?><a href="index.php?page=<?php echo $page - 1; ?>">Previous page</a> — <?php
  endif;
  
  for ($i = 1; $i <= $nombreDePages; $i++):
      ?><a href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a> <?php
  endfor;
  
  if ($page < $nombreDePages):
      ?>— <a href="index.php?page=<?php echo $page + 1; ?>">Next page</a><?php
  endif;



?></div>
      </div>  
      <div class="wrapper-foot">
          sivinska &copy; - Camagru - 2019
</div>
    </div>



</body>



 


</html>

<?php
}
?>
