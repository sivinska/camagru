<?php
include('../config/database.php');
if(isset($_GET['token']))
{
    $query = "SELECT * FROM users WHERE token = :token AND username =:username";
    if ($stmt = $pdo->prepare($query))
    {
        $stmt->bindParam(":token", $_GET['token'], PDO::PARAM_STR);
        $stmt->bindParam(":username", $_GET['username'], PDO::PARAM_STR);
        if ($stmt->execute()){
            $result = $stmt->fetchAll();
            $user_id = $result[0]['user_id'];
            header ('location: updatePassword.php?id='.$user_id.'');
        }
        
        
        
    }
        
}
?>