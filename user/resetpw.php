<?php

session_start();
require_once "../config/database.php";



$username = $email = $newpw = $confirm_newpw = "";
$username_err = $email_err = $newpw_err = $confirm_newpw_err = "";


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }


if (!$_SESSION['logged'] && $_SERVER["REQUEST_METHOD"] == "POST")
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="type" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($newpw_err)) ? 'has-error' : ''; ?>">
                <label>New Password</label>
                <input type="password" name="newpw" class="form-control" value="<?php echo $newpw; ?>">
                <span class="help-block"><?php echo $newpw_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_newpw_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_newpw" class="form-control">
                <span class="help-block"><?php echo $confirm_newpw_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="welcome.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>
