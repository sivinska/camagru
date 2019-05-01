<?php 
session_start();
require_once "../config/database.php";
include "nav.php";

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../index.php");
    exit;
  }


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

$username = $_GET['username'];
$token = $_GET['token'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(test_input($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } else{
        $password = test_input($_POST["password"]);
    }
    
    if(empty(test_input($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = test_input($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    if(empty($password_err) && empty($confirm_password_err) && empty($email_err)){
    $sql = "UPDATE users SET password =:password WHERE username = :username AND token =:token";
    if ($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
        $stmt->bindParam(":token", $token);
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
        if ($stmt->execute()){
            $success ='Your password has been changed.';
            $sql = "UPDATE users SET token = :token WHERE username = :username";
            if ($stmt = $pdo->prepare($sql))
            {
                $stmt->bindParam(":token", $new_token);
                $stmt->bindParam(":username", $username);
                $new_token = md5( rand(0,1000) );
                $stmt->execute();

            }
                header("Refresh: 2; url=login.php");
        }

    }

    }
}



?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Password reset</title>
  <link rel="stylesheet" href="../style/style.css">  
  <link href="https://fonts.googleapis.com/css?family=Lora:400,700i" rel="stylesheet">
  
</head>

<body>
    <div id="container" class="login">
        <div class="wrap-login">
        <span class="success"><?php echo $success; ?></span>
            <span class="form-title">Reset your password</span>
            <form action="updatePassword.php?username=<?php echo test_input($username); ?>&token=<?php echo test_input($token); ?>" method="post">

                    <span class="help-block"><?php echo $password_err; ?></span>   
                    <div class="wrap-input" <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>>
                    <input class="input" type="password" name="password" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required
                     class="form-control" value="<?php echo $password; ?>">
                    <span class="focus-input"></span>
                    </div>

                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                    <div class="wrap-input" <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>>
                    <input class="input" type="password" name="confirm_password" placeholder="Confirm password" class="form-control" value="<?php echo $confirm_password; ?>">
                    <span class="focus-input"></span>
                    </div>

                    <div class="button-container">
                    <button class="button">Reset</button>
                    </div>                
                </form>
        </div>
    </div>
<footer class="wrapper-foot">
          sivinska &copy; - Camagru - 2019
</footer>
</body>
</html>
