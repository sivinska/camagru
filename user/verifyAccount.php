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
                    header("Location: login.php");
                }
            }
            else{
                $message = '<label class="text-info">Your Email Address Already Verified</label>';
                header("location: login.php");
            }
        }
    }
    else{
        $message = '<label class="text-danger">Invalid Link</label>';
    }
    
}

?>
