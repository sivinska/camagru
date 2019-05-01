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

// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = $activation_code = $success = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    //Validate email
    if(empty(test_input($_POST["email"]))){
        $email_err = "Please enter your email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT user_id FROM users WHERE email = :email";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            
            // Set parameters
            $param_email = test_input($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $email_err = "This email is already taken.";
                } 
                else{
                    $email = test_input($_POST["email"]);
                }
            } 
            else {
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
        $sql = "SELECT user_id FROM users WHERE username = :username";
        
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
        $sql = "INSERT INTO users (email, username, password, token, activation_code, status, notification) VALUES (:email, :username, :password, :token, :activation_code, :status, :notification)";
         
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":activation_code", $param_activation_code, PDO::PARAM_STR);
            $stmt->bindParam(":status", $param_status, PDO::PARAM_STR);
            $stmt->bindParam(":token", $param_token, PDO::PARAM_STR);
            $stmt->bindParam(":notification", $param_notif, PDO::PARAM_STR);       
                
            
            // Set parameters
            $param_email = $email;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_activation_code = md5( rand(0,1000) );
            $param_status = 'not verified';
            $param_token = md5( rand(0,1000) );
            $param_notif = 'yes';
            
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
                http://localhost:8080/user/verifyAccount.php?username='.$username.'&activation_code='.$param_activation_code.'
                 
                '; // Our message above including the link
                                     
                $headers = 'From:noreply@camagru.com' . "\r\n"; // Set from headers
                (mail($to, $subject, $message, $headers));
                $success ='Activation code has been sent to your account.';
                header("Refresh: 3; url=login.php");
                
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
<html>
<head>
  <meta charset="UTF-8">
  <title>Create an account</title>
  <link rel="stylesheet" href="../style/style.css">  
  <link href="https://fonts.googleapis.com/css?family=Lora:400,700i" rel="stylesheet">

</head>

<body>
    <div id="container" class="login">
        <div class="wrap-login">
            <span class="success"><?php echo $success; ?></span>
            <span class="form-title">Create an account</span>
            
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <span class="help-block"><?php echo $email_err; ?></span>
                    <div class="wrap-input" <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>>
                    <input class="input" type="email" name="email" placeholder="Email" class="form-control" value="<?php echo $email; ?>">
                    <span class="focus-input"></span>
                    </div>

                    <span class="help-block"><?php echo $username_err; ?></span> 
                    <div class="wrap-input" <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>>
                    <input class="input" type="text" name="username" placeholder="Username" class="form-control" value="<?php echo $username; ?>">
                    <span class="focus-input"></span>
                    </div>

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
                    <button class="button">Sign In</button>
 
                    </div>
                    <p class="pstyle">Already have an account? <a href="login.php">Login here.</a></span>
               
                </form>
        </div>
    </div>
    <footer class="wrapper-foot">
          sivinska &copy; - Camagru - 2019
</footer>
</body>
</html>