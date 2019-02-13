<?php
session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
require_once "../config/database.php";
include "nav.php";
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }


$username = $password = "";
$username_err = $password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(test_input($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = test_input($_POST["username"]);
    }
    
    if(empty(test_input($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = test_input($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT * FROM users WHERE username = :username";
        
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            $param_username = test_input($_POST["username"]);
            
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetchAll()){
                        if ($row[0]['status'] == 'verified'){
                        $id = $row[0]["id"];
                        $username = $row[0]["username"];
                        $hashed_password = $row[0]["password"];
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            header("location: index.php");
                        } else{
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                        else
                            $username_err = "Please check your mail to verify your account.";
                    }
                } else{
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        unset($stmt);
    }
    
    unset($pdo);
}
?>
 
 <!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">  
</head>

<body>
<div id="container" class="login">
    <div class="wrap-login">
        <span class="form-title">Login</span>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <span class="help-block"><?php echo $username_err; ?></span> 
                <div class="wrap-input" <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <input class="input" type="text" name="username" placeholder="Username" class="form-control" value="<?php echo $username; ?>">
                <span class="focus-input"></span>
                </div>

                <span class="help-block"><?php echo $password_err; ?></span>   
                <div class="wrap-input" <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <input class="input" type="password" name="password" placeholder="Password" class="form-control" value="<?php echo $password; ?>">
                <span class="focus-input"></span>
                </div>
            
                <div class="button-container">
                <button class="button">Login</button>
                </div>
                <p class ="pstyle">Don't have an account? <a href="register.php">Sign up now</a>.</p>
                <p class ="pstyle">Forgot your password? <a href="reset.php">Click here</a>.</p>
                
            </form>
    </div>
</div>
</body>
</html>