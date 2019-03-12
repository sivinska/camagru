<?php // Include config file

require_once "../config/database.php";
include "nav.php";

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

$user_id = $_GET['id'];

 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    if(empty(test_input($_POST["email"]))){
        $email_err = "Please enter your email.";
    } else{
        $sql = "SELECT * FROM users WHERE email = :email AND user_id = :user_id";
        
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
            
            $param_email = test_input($_POST["email"]);
            
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $email = test_input($_POST["email"]);

                    
                } else{
                    $email_err = "Email don't match with your account.";
                
            } 
        }
        else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        // Close statement
        unset($stmt);
    }
 
    
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
    $sql = "UPDATE users SET password =:password, token=:token WHERE user_id = :user_id AND email =:email";
    if ($stmt = $pdo->prepare($sql)){
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
        $stmt->bindParam(":token", $token);
        $token =  md5( rand(0,1000) );
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
        if ($stmt->execute()){
            $success ='Your password has been changed.';
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
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css?family=Lora:400,700i" rel="stylesheet">
  
</head>

<body>
    <div id="container" class="login">
        <div class="wrap-login">
        <span class="success"><?php echo $success; ?></span>
            <span class="form-title">Reset your password</span>
            <form action="updatePassword.php?id=<?php echo test_input($user_id); ?>" method="post">

                    <span class="help-block"><?php echo $email_err; ?></span>
                    <div class="wrap-input" <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>>
                    <input class="input" type="email" name="email" placeholder="Email" class="form-control" value="<?php echo $email; ?>">
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
                    <button class="button">Reset</button>
                    </div>                
                </form>
        </div>
    </div>
<div class="wrapper-foot">
    sivinska &copy; - Camagru - 2019
</div>
</body>
</html>
