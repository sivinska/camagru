<?php
session_start();
 
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home.php");
    exit;
}
 
require_once "../config/database.php";

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
                            
                            header("location: home.php");
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
<div class="container-login100" class="bgded overlay" style="background-image: url('https://images.unsplash.com/photo-1513652990199-8a52e2313122?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1650&q=80');">
      <div class="wrapper row1">
    <nav>
  <ul>
    <li>
    <?php
		  	if ($_SESSION["loggedin"] == true)
			{
				echo '<a href="home.php">Home</a>';
			}
			else
			{
		        echo '<a href="indexpage.php">Home</a>';
			}
		?>
    </li>
    <li>
      <a href="#">Gallery</a>
    </li>
    <li>
      <a href="#">Your account</a>
    </li>
    
  </ul>
    </nav>
      </div>
        <div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
        <span class="login100-form-title p-b-37">Login</span>
            <form class="login100-form validate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                <span class="help-block"><?php echo $username_err; ?></span> 
                <div class="wrap-input100 validate-input m-b-25"  class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <!--label>Username</label-->
                <input class="input100" type="text" name="username" placeholder="Username" class="form-control" value="<?php echo $username; ?>">
                <span class="focus-input100"></span>
                </div>

                <span class="help-block"><?php echo $password_err; ?></span>   
                <div class="wrap-input100 validate-input m-b-25" class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <!--label>Password</label-->
                <input class="input100" type="password" name="password" placeholder="Password" class="form-control" value="<?php echo $password; ?>">
                <span class="focus-input100"></span>
                </div>
            
                <div class="container-login100-form-btn">
                <button class="login100-form-btn">Login</button>
                </div>
                <p class ="pstyle">Don't have an account? <a href="register.php">Sign up now</a>.</p>
                <p class ="pstyle">Forgot your password? <a href="test.php">Click here</a>.</p>
                
            </form>
        </div>
    </div>
</body>
</html>