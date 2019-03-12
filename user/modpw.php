<?php

session_start();
require_once "../config/database.php";
include "nav.php";

if(!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"] === true){
    header("location: login.php");
    exit;
  }

  $oldpw = $newpw = $confirm_newpw = "";
  $oldpw_err = $newpw_err = $confirm_newpw_err = "";

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  
if ($_SESSION["loggedin"] && $_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty(test_input($_POST["oldpw"])))
        $oldpw_err = "Please enter your password.";
    else
        $oldpw = test_input($_POST["oldpw"]);

    if(empty(test_input($_POST["newpw"])))
        $newpw_err = "Please enter a password.";
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
    if (empty($oldpw_err) && empty($newpw_err) && empty($confirm_newpw_err)){
      
      $sql = "SELECT * FROM users WHERE user_id = :user_id";
      if ($stmt = $pdo->prepare($sql)){
          $stmt->bindParam("user_id", $_SESSION['user_id'], PDO::PARAM_STR);
          
        if ($stmt->execute()){
            $result = $stmt->fetchAll();
            $hashed_pw = $result[0]['password'];
            if (password_verify($oldpw, $hashed_pw)){
                $sql = "UPDATE users SET password = :password WHERE user_id = :user_id";
                if ($stmt = $pdo->prepare($sql)){
                    $stmt->bindParam("password", $param_newpw, PDO::PARAM_STR);
                    $param_newpw = password_hash($newpw, PASSWORD_DEFAULT);
                    $stmt->bindParam("user_id", $_SESSION['user_id'], PDO::PARAM_STR);
                    if ($stmt->execute()){
                        $success = 'Your password has been updated';
                    }
                    else{
                        echo "Something went wrong";
                    }       
                }
            }
          }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Your account</title>
  <link rel="stylesheet" href="style.css">  
  <link href="https://fonts.googleapis.com/css?family=Lora:400,700i" rel="stylesheet">
</head>
<body>
<div id="container" class="gallery">  
    <div id="main">
        <div class="wrapper2">
            <aside>
                <table class="table">
                  <tr class="pointer" onclick="window.location.href='usermail.php'"><td>
                  Modify your email and username
                  </td></tr>
                  <tr class="pointer" onclick="window.location.href='modpw.php'"><td>
                  Change your password
                  </td></tr>
                  <tr class="pointer" onclick="window.location.href='delphoto.php'"><td>
                  Delete photos
                  </td></tr>
               </table>
              </aside>
            <article>
                <div class="wrap-login margin top">
                    <span class="success"><?php echo $success; ?></span>
                    <span class="form-title">Change your password</span>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <span class="help-block"><?php echo $oldpw_err; ?></span>
                            <div class="wrap-input" <?php echo (!empty($oldpw_err)) ? 'has-error' : ''; ?>>
                            <input class="input" type="password" name="oldpw" placeholder="Old password" class="form-control" value="<?php echo $oldpw; ?>">
                            <span class="focus-input"></span>
                            </div>

                            <span class="help-block"><?php echo $newpw_err; ?></span> 
                            <div class="wrap-input" <?php echo (!empty($newpw_err)) ? 'has-error' : ''; ?>>
                            <input class="input" type="password" name="newpw" placeholder="New password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required
                            class="form-control" value="<?php echo $newpw; ?>">
                            <span class="focus-input"></span>
                            </div>

                            <span class="help-block"><?php echo $confirm_newpw_err; ?></span> 
                            <div class="wrap-input" <?php echo (!empty($confirm_newpw_err)) ? 'has-error' : ''; ?>>
                            <input class="input" type="password" name="confirm_newpw" placeholder="Confirm new password" class="form-control" value="<?php echo $confirm_newpw; ?>">
                            <span class="focus-input"></span>
                            </div>

                            <div class="button-container">
                            <button class="button">Submit</button>
                            </div>
                        </form>
                 </div>
            </article>
        </div>
    </div>
<div class="wrapper-foot">
    sivinska &copy; - Camagru - 2019
</div>
</body>
</html>