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
       
        if($pw = $result[0]['password'] !== NULL){
            var_dump($pw);
            $update ="UPDATE users SET password = :password WHERE username = :username";
            if ($stmt = $pdo->prepare($update))
            {
                $stmt->bindParam(":username", $_GET['username'], PDO::PARAM_STR);
                $stmt->bindParam(":password", '', PDO::PARAM_STR);
                $stmt->execute();
                $res = $stmt->fetchAll();
            }
        
        }
    
   }
}

//reiketu unst stmt ir deader to new location, kur reiketu ivesti email, username, new pw ir confirm new pw.
?>
