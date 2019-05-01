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

$query = "SELECT * FROM users WHERE user_id = :user_id";
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
        $stmt->execute();   
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Your profile</title>
  <link rel="stylesheet" href="../style/style.css">  
  <link href="https://fonts.googleapis.com/css?family=Lora:400,700i" rel="stylesheet">
</head>
<body>
<div id="container" class="gallery">  
    <div id="main">
        <div class="wrapper2">
            <aside>
                <table class="table">
                    <tr class="pointer" onclick="window.location.href='usermail.php'"><td>
                    Modify your email and username
                    </td></tr>
                    <tr class="pointer" onclick="window.location.href='modpw.php'"><td>
                    Change your password
                    </td></tr>
                    <tr class="pointer" onclick="window.location.href='delphoto.php'"><td>
                    Delete photos
                    </td></tr>
                </table>
            </aside>
            <article>
                <div class="wrap-login margin top">
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
                        <div class="center">
                            Do you wish to recieve notification by mail?
                        <label class="container">Yes
                        <input class="checkbox" type="checkbox" <?php if ($result[0]['notification'] === 'yes') { echo 'checked="checked"'; } ?> name="notif" onclick="window.location.href='notif.php'">
                            <span class="checkmark"></span>
                        </label>
                        </div>
                        <div class="button-container">
                        <button class="button">Submit</button>
                        </div>
                    </form>
                </div>
            </article>
        </div>
    </div>
</div>
<footer class="wrapper-foot">
          sivinska &copy; - Camagru - 2019
</footer>

</body>
</html>