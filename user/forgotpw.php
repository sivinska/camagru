<?php
session_start();

require_once "../config/database.php";

$newpw = $confirm_newpw = "";
$newpw_err = $confirm_newpw_err = "";

if (!$_SESSION["logged"] && $_SERVER["REQUEST_METHOD"] == "POST")
{
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

	if (empty($newpw_err) && empty($confirm_newpw_err))
	{
		$sql = "SELECT id, username, password, secret FROM users WHERE username = ?";
		if($stmt = mysqli_prepare($connection, $sql))
		{
			mysqli_stmt_bind_param($stmt, "s", $param_username);
			$param_username = $username;
			if(mysqli_stmt_execute($stmt))
			{
				mysqli_stmt_store_result($stmt);
				if(mysqli_stmt_num_rows($stmt) == 1)
				{
					mysqli_stmt_bind_result($stmt, $id, $username, $hashed_pw, $hashed_secret);
					if (mysqli_stmt_fetch($stmt))
					{
						if (password_verify($secret, $hashed_secret))
						{
							$sql = "UPDATE users SET password = ? WHERE id = ?";
							if ($stmt = mysqli_prepare($connection, $sql))
							{
								mysqli_stmt_bind_param($stmt, "si", $param_newpw, $param_id);
								$param_newpw = password_hash($newpw, PASSWORD_DEFAULT);
								$param_id = $id;
								if(mysqli_stmt_execute($stmt))
					                header("location: index.php");
					            else
					                echo "Something went wrong. Please try again later.";
							}
						}
						else
							$secret_err = "Wrong answer.";
					}
				}
				else
					echo "User not found...";
			}
		}
		else
		{
			echo "Something went wrong. Please try again later.";
		}
		// Close statement
		mysqli_stmt_close($stmt);
	}

	// Close connection
	mysqli_close($connection);

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
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="welcome.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>
