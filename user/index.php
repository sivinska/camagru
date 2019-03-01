<?php
session_start();
require_once "../config/database.php";


include "nav.php";
$sql = "SELECT * FROM images ORDER BY date DESC";
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
              <img src="<?php echo $pic['photo']; ?>">
               <button onclick="window.location.href='action.php?id=<?php echo $pic['photo_id']; ?>'">
               Comment</button>
              </div>  
            <?php }
        ?>
        </div>
        
      </div>       
    </div>

<!--script>

var buttons = document.getElementsByTagName("button");
var buttonsCount = buttons.length;
for (var i = 0; i < buttonsCount; i++) {
    buttons[i].onclick = function(e) {
        var photo_id = this.id;
      xhr = new XMLHttpRequest();

xhr.open('POST', `action.php?name=`);
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xhr.onload = function() {
    if (xhr.status === 200 && xhr.responseText !== photo_id) {
        alert('Something went wrong.  Name is now ' + xhr.responseText);
    }
    else if (xhr.status !== 200) {
        alert('Request failed.  Returned status of ' + xhr.status);
    }
};
xhr.send(encodeURI('name=' + photo_id));

      
           };

  }













</script-->


</body>






</html>


