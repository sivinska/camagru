<?php
session_start();
require_once "../config/database.php";
include "nav.php";

$username = $email = "";
$username_err = $email_err = "";

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty(test_input($_POST["username"])))
		$username_err = "Please enter your username.";
	else
		$username = test_input($_POST["username"]);

	if(empty(test_input($_POST["email"])))
		$email_err = "Please enter your email address.";
	else
        $email = test_input($_POST["email"]);


	if (empty($username_err) && empty($email_err))
	{
		$sql = "SELECT * FROM users WHERE username = :username AND email = :email";
		if($stmt =$pdo->prepare($sql))
		{
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            $stmt->execute();

			$result = $stmt->fetchAll();
            $param_token = $result[0]['token'];


			if($stmt->execute())
			{
				$to      = $email; // Send email to our user
                $subject = 'Reset your password'; // Give the email a subject 
                $message = '
                 
                Thanks for signing up!
                Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
                 
                ------------------------

                Username: '.$username.'
                
                ------------------------
                 
                Please click this link to activate your account:
                http://localhost:8080/user/checkToken.php?username='.$username.'&token='.$param_token.'
                 
                '; // Our message above including the link
                                     
                $headers = 'From:noreply@camagru.com' . "\r\n"; // Set from headers
                (mail($to, $subject, $message, $headers)); // Send our email
                $success="Email to reset your password has been sent.";
                header("Refresh: 3; url=login.php");
		}
		else
		{
			echo "Something went wrong. Please try again later.";
		}
		// Close statement
		
	}
unset($stmt);
	// Close connection
	

}
unset($pdo);
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Password reset</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">  
  
</head>

<body>
    <div id="container" class="login">
        <div class="wrap-login">
        <span class="success"><?php echo $success; ?></span>
            <span class="form-title">Reset your password</span>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <span class="help-block"><?php echo $username_err; ?></span> 
                    <div class="wrap-input" <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <input class="input" type="text" name="username" placeholder="Username" class="form-control" value="<?php echo $username; ?>">
                    <span class="focus-input"></span>
                    </div>

                    <span class="help-block"><?php echo $email_err; ?></span>
                    <div class="wrap-input" <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <input class="input" type="email" name="email" placeholder="Email" class="form-control" value="<?php echo $email; ?>">
                    <span class="focus-input"></span>
                    </div>

                    <div class="button-container">
                    <button class="button">Reset</button>
                    </div>                
                </form>
        </div>
    </div>
</body>
</html>