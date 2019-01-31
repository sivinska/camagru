<?php

include('../config/database.php');

$message = '';

if(isset($_GET['activation_code']))
{
    $query = "SELECT * FROM users WHERE activation_code = :activation_code";
    $stmt = $pdo->prepare($query);
    $stmt->execute(array(':activation_code'   => $_GET['activation_code']));
 
    $no_of_row = $stmt->rowCount();
 
    if($no_of_row > 0){
        $result = $stmt->fetchAll();
        foreach($result as $row){
            if($row['status'] == 'not verified'){    
                $update_query = "UPDATE users SET status = 'verified' WHERE username = :username";
                $stmt = $pdo->prepare($update_query);
                $stmt->execute(array(':username' => $_GET['username']));
                $sub_result = $stmt->fetchAll();
                if(isset($sub_result)){
                    $message = '<label class="text-success">Your Email Address Successfully Verified <br />You can login here - <a href="login.php">Login</a></label>';
                }
            }
            else{
                $message = '<label class="text-info">Your Email Address Already Verified</label>';
            }
        }
    }
    else{
        $message = '<label class="text-danger">Invalid Link</label>';
    }
}

?>
<!DOCTYPE html>
<html>
 <head>
  <title>PHP Register Login Script with Email Verification</title>  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  
  <div class="container">
   <h1 align="center">PHP Register Login Script with Email Verification</h1>
  
   <h3><?php echo $message; ?></h3>
   
  </div>
 
 </body>
 
</html>