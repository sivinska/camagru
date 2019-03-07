<?php

session_start();
require_once "../config/database.php";
include "nav.php";

if(!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"] === true){
    header("location: login.php");
    exit;
  }

$username = $email  = "";
$username_err = $email_err = "";

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

$query = "SELECT username, email, password FROM users WHERE user_id = :user_id";
if ($stmt = $pdo->prepare($query)){
    $stmt->bindParam("user_id", $_SESSION['user_id'], PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetchAll();
}

//username

if(empty(test_input($_POST["username"]))){
    $username = $_SESSION['username'];
} else{
    $sql = "SELECT user_id FROM users WHERE username = :username";  
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
        $param_username = test_input($_POST["username"]);
        if($stmt->execute()){
            if($stmt->rowCount() == 1 && $param_username !== $_SESSION['username']){
                $username_err = "This username is already taken.";
            } else{
                $username = test_input($_POST["username"]);
                $success = 'Your account has been updated';
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    unset($stmt);
}


if(empty(test_input($_POST["email"]))){
    $email = $result[0]['email'];
} 
else{
    $sql = "SELECT user_id FROM users WHERE email = :email";
    if($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
        $param_email = test_input($_POST["email"]);
        if($stmt->execute()){
            if($stmt->rowCount() == 1 && $param_email !== $result[0]['email']){
                $email_err = "This email is already taken.";
            } 
            else{
                $email = test_input($_POST["email"]);
                $success = 'Your account has been updated';
            }
        } 
        else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    
    unset($stmt);
}







if (!empty($username) ){
    $sql = "UPDATE users SET username = :username WHERE user_id = :user_id";
    if ($stmt = $pdo->prepare($sql)){
        $stmt->bindParam("username", $username, PDO::PARAM_STR);
        $stmt->bindParam("user_id", $_SESSION['user_id'], PDO::PARAM_STR);
        if ($stmt->execute()){
            $_SESSION['username'] = $username;
        }
    }
}

if (!empty($email) ){
    $sql = "UPDATE users SET email =:email WHERE user_id = :user_id";
    if ($stmt = $pdo->prepare($sql)){
        $stmt->bindParam("email", $email, PDO::PARAM_STR);
        $stmt->bindParam("user_id", $_SESSION['user_id'], PDO::PARAM_STR);
        if ($stmt->execute()){
            
        }
    }
}




?>









<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Camera</title>
  <link rel="stylesheet" href="style.css"> 
  <link href="https://fonts.googleapis.com/css?family=Lora:400,700i" rel="stylesheet">
 
</head>


<body>

<div id="container" class="gallery">  
<div id="main">
<div class="wrapper2">
    <header>Your profile!</header>
    <aside>
        <form action="usermail.php" method="post">
			<button type="submit" class="button">Email and Username</button>
        </form>
        <form action="modpw.php" method="post">
			<button type="submit" class="button">Password</button>
        </form>
        <form action="delphoto.php" method="post">
			<button type="submit" class="button">Photos</button>
		</form>
    </aside>
    <article>
    
        <div class="wrap-login margin">

            



            <span class="success"><?php echo (empty($email_err) && empty($username_err)) ? $success : ''; ?></span>
            <span class="form-title">Modify your email and username</span>
            
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <span class="help-block"><?php echo $email_err; ?></span>
                    <div class="wrap-input" <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>>
                    <input class="input" type="email" name="email" placeholder="Modify your email" class="form-control" value="<?php echo $email; ?>">
                    <span class="focus-input"></span>
                    </div>

                    <span class="help-block"><?php echo $username_err; ?></span> 
                    <div class="wrap-input" <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>>
                    <input class="input" type="text" name="username" placeholder="Modify your username" class="form-control" value="<?php echo $username; ?>">
                    <span class="focus-input"></span>
                    </div>
                    
                    <div>Do you wish to receive notfications by mail?</div>
                    




                    <div class="button-container">
                    <button class="button">Submit</button>
 
                    </div>
               
                </form>
     
    </div>
</article>
<script>

</script>
</body>
</html>