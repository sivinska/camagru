<?php

session_start();
require_once "../config/database.php";
include "nav.php";

if(!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"] === true){
    header("location: login.php");
    exit;
  }

$username = $email = $newpw = $confirm_newpw = "";
$username_err = $email_err = $newpw_err = $confirm_newpw_err = "";


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }


if (!$_SESSION['loggedin'] && $_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty(test_input($_POST["username"])))
		$username_err = "Please enter your username.";
	else
		$username = test_input($_POST["username"]);

	if(empty(test_input($_POST["email"])))
		$email_err = "Please enter your email.";
	else
		$email = test_input($_POST["email"]);

	if(empty(test_input($_POST["newpw"])))
		$newpw_err = "Please enter a password.";
	elseif(strlen(test_input($_POST["newpw"])) < 6)
		$newpw_err = "Password must have atleast 6 characters.";
	else
		$newpw = test_input($_POST["newpw"]);

	if(empty(test_input($_POST["confirm_newpw"])))
		$confirm_newpw_err = "Please confirm password.";
	else
	{
		$confirm_newpw = test_input($_POST["confirm_newpw"]);
        if(empty($newpw_err) && ($newpw != $confirm_newpw))
            $confirm_newpw_err = "Password did not match.";
    }

    if (empty($username_err) && empty($email_err) && empty($newpw_err) && empty($confirm_newpw_err))
    {
        $sql = "UPDATE users SET password = :password WHERE username = :username AND email = :email";
        if ($stmt = $pdo->prepare($sql))
        {
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $newpw, PDO::PARAM_STR);

            $newpw = password_hash($newpw, PASSWORD_DEFAULT);
            if ($stmt->execute()){
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";

            }
        }
    }
}



?>










<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Your details</title>
  <link rel="stylesheet" href="style.css">  
</head>

<body>
    <div id="container" class="login">
        <div class="wrap-login">
            <span class="success"><?php echo $success; ?></span>
            <span class="form-title">Modify your account</span>
            
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <span class="help-block"><?php echo $email_err; ?></span>
                    <div class="wrap-input" <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>>
                    <input class="input" type="email" name="email" placeholder="<?php $_SESSION['email']?>" class="form-control" value="<?php echo $email; ?>">
                    <span class="focus-input"></span>
                    </div>

                    <span class="help-block"><?php echo $username_err; ?></span> 
                    <div class="wrap-input" <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>>
                    <input class="input" type="text" name="username" placeholder="Username" class="form-control" value="<?php echo $username; ?>">
                    <span class="focus-input"></span>
                    </div>

                    <span class="help-block"><?php echo $password_err; ?></span>   
                    <div class="wrap-input" <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>>
                    <input class="input" type="password" name="password" placeholder="Password" class="form-control" value="<?php echo $password; ?>">
                    <span class="focus-input"></span>
                    </div>

                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                    <div class="wrap-input" <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>>
                    <input class="input" type="password" name="confirm_password" placeholder="Confirm password" class="form-control" value="<?php echo $confirm_password; ?>">
                    <span class="focus-input"></span>
                    </div>

                    <div class="button-container">
                    <button class="button">Submit</button>
 
                    </div>
               
                </form>
        </div>
    </div>
</body>
</html>