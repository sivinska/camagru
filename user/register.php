<?php
// Include config file
require_once "../config/database.php";
 
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = $activation_code = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    //Validate email
    if(empty(test_input($_POST["email"]))){
        $email_err = "Please enter your email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = :email";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            
            // Set parameters
            $param_email = test_input($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                /*if($stmt->rowCount() == 1){
                    $email_err = "This email is already taken.";
                } else{*/
                    $email = test_input($_POST["email"]);
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        unset($stmt);
    }


    // Validate username
    if(empty(test_input($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = test_input($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = test_input($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Validate password
    if(empty(test_input($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(test_input($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = test_input($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(test_input($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = test_input($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (email, username, password, token, activation_code, status) VALUES (:email, :username, :password, :token, :activation_code, :status)";
         
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":activation_code", $param_activation_code, PDO::PARAM_STR);
            $stmt->bindParam(":status", $param_status, PDO::PARAM_STR);
            $stmt->bindParam(":token", $param_token, PDO::PARAM_STR);      
            var_dump($stmt);      
            
            // Set parameters
            $param_email = $email;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_activation_code = md5( rand(0,1000) );
            $param_status = 'not verified';
            $param_token = md5( rand(0,1000) );
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){

                
                $to      = $email; // Send email to our user
                $subject = 'Signup | Verification'; // Give the email a subject 
                $message = '
                 
                Thanks for signing up!
                Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
                 
                ------------------------

                Username: '.$username.'
                
                ------------------------
                 
                Please click this link to activate your account:
                http://localhost:8080/user/verify.php?username='.$username.'&activation_code='.$param_activation_code.'
                 
                '; // Our message above including the link
                                     
                $headers = 'From:noreply@camagru.com' . "\r\n"; // Set from headers
                var_dump(mail($to, $subject, $message, $headers)); // Send our email
                             
                // Redirect to login page
                //header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
          
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
}
?>
 
 <!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>camagru</title>
  
  
  
      <link rel="stylesheet" href="style.css">

  
</head>

<body>

  <html lang="en"><head>
	<title>Create an account</title>
	<meta charset="UTF-8">
</head>
<body style="background-color: #666666;">
	
	<div class="limits">
		<div class="container">
			<div class="wrap">
				<div>
        
        <form class="form">
          <span class="form-title padding">Sign Up</span>
        <span class="form-title padding">Please fill this form to create an account.</span>
          
            <div class="wrap-input validate-input">
                <label>Email</label>
                <input class="input100" type="email" name="email">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div> 

            <div class="wrap-input validate-input">
                <label>Username</label>
                <input class="input100" type="text" name="username">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="wrap-input validate-input">
                <label>Password</label>
                <input class="input100" type="password" name="password">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="wrap-input validate-input">
                <label>Confirm Password</label>
                <input class="input100" type="password" name="confirm_password">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="container-form-btn">
              <button class="form-btn">Register</button>
 
            </div>
          <div class="text-center p-t-46 p-b-20">
						<span >
							Already have an account? <a href="login.php">Login here</a>.
						</span>
					</div>
            
        </form>
    </div>    

				<div class="more" style="background-image: url('https://images.unsplash.com/photo-1465161191540-aac346fcbaff?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=1950&amp;q=80');">
				</div>
			</div>
		</div>
	</div>
	
	

	
	

	

	

	
	

	

	
	

	

	


</body></html>
  
  

</body>

</html>





<!--!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div> 

            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>