<?php
session_start();
require_once "../config/database.php";


include "nav.php";





?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome to Camagru</title>
  <link rel="stylesheet" href="style.css">

<link href="https://fonts.googleapis.com/css?family=Lora:400,700i" rel="stylesheet"></head>
<body>
    <div id="container" class="gallery">
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
  /* On doit extraire le nombre du jeu de résultat */
    $nombredElementsTotal = $resultFoundRows->fetchColumn();
    $nombreDePages = ceil($nombredElementsTotal / $limit);
    
  


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
            <?php }}
        ?>
        </div>
<?php
if ($page > 1):
      ?><a href="index.php?page=<?php echo $page - 1; ?>">Page précédente</a> — <?php
  endif;
  
  /* On va effectuer une boucle autant de fois que l'on a de pages */
  for ($i = 1; $i <= $nombreDePages; $i++):
      ?><a href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a> <?php
  endfor;
  
  /* Avec le nombre total de pages, on peut aussi masquer le lien
   * vers la page suivante quand on est sur la dernière */
  if ($page < $nombreDePages):
      ?>— <a href="index.php?page=<?php echo $page + 1; ?>">Page suivante</a><?php
  endif;



?>
      </div>       
    </div>



</body>






</html>


