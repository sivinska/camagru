<?php
session_start();
require_once "../config/database.php";

$username = $email = "";
$username_err = $email_err = "";

/*if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}*/

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
            var_dump($param_token);


			if($stmt->execute())
			{
                echo "i am here";
                var_dump($stmt);
				$to      = $email; // Send email to our user
                $subject = 'Reset your password'; // Give the email a subject 
                $message = '
                 
                Thanks for signing up!
                Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
                 
                ------------------------

                Username: '.$username.'
                
                ------------------------
                 
                Please click this link to activate your account:
                http://localhost:8080/user/verifypw.php?username='.$username.'&token='.$param_token.'
                 
                '; // Our message above including the link
                                     
                $headers = 'From:noreply@camagru.com' . "\r\n"; // Set from headers
                var_dump(mail($to, $subject, $message, $headers)); // Send our email
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
</head>

<body>
    <div class="container-login100" style="background-image: url('https://images.unsplash.com/photo-1519636243899-5544aa477f70?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80');">
        <div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
        <span class="login100-form-title p-b-37">Reset your password</span>
            <form class="login100-form validate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <span class="help-block"><?php echo $username_err; ?></span> 
                <div class="wrap-input100 validate-input m-b-25"  class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <!--label>Username</label-->
                <input class="input100" type="text" name="username" placeholder="Username" class="form-control" value="<?php echo $username; ?>">
                <span class="focus-input100"></span>
                </div>

                <span class="help-block"><?php echo $email_err; ?></span>
                <div class="wrap-input100 validate-input m-b-25" class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <!--label>Email</label-->
                <input class="input100" type="email" name="email" placeholder="Email" class="form-control" value="<?php echo $email; ?>">
                <span class="focus-input100"></span>
                </div>
            
                <div class="container-login100-form-btn">
                <button class="login100-form-btn">Reset</button>
                </div>                
            </form>
        </div>
    </div>
</body>
</html>