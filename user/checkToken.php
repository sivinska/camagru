<?php

include('../config/database.php');


if(isset($_GET['token']))
{
    $query = "SELECT * FROM users WHERE token = :token";
    if ($stmt = $pdo->prepare($query))
    {
        $stmt->bindParam(":token", $_GET['token'], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
        
       
        if($pw = $result[0]['password']){
            $update ="UPDATE users SET password = '' WHERE username = :username";
            if ($stmt = $pdo->prepare($update))
            {
                $stmt->bindParam(":username", $_GET['username'], PDO::PARAM_STR);
                if($stmt->execute()){
                    header('location: updatePassword.php');
                }
                else
                   echo "error";
                
            }
        
        }
        else
            echo "errrror";
      //  unset($stmt);
    
   }
   else
    echo "something is wrong";
  // unset($pdo);
}


//reiketu unst stmt ir deader to new location, kur reiketu ivesti email, username, new pw ir confirm new pw.
?>
