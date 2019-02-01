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
		<meta charset="utf-8">
		<title>Password forget</title>
	</head>
	<body>
		<form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<div class="wrapper">
                <h1>Reset your password</h1>
                <p>Please fill in this form to reset your password.</p>
                <hr>
				<label>Username</label>
				<input type="text" name="username" value="">
				<span style='color:red;'><?php echo $username_err; ?></span>
			
				<label>Email</label>
				<input type="email" name="email" value="">
				<span style='color:red;'><?php echo $email_err; ?></span>
			

				<br />
				<button type="submit" class="btn btn-primary">Reset</button>
		
			</div>
		</form>
	</body>
</html>