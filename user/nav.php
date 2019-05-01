<header class="wrapper">
  <nav>
    <ul>
      <li><a href="../index.php">Gallery</a></li>
      <li>
      <?php
		  	if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
        {
          echo '<a href="../user/account.php">Your account</a>';
        }
        else{
          echo '
                
                  <li><a href="../user/login.php">Login</a></li>
                  <li><a href="../user/register.php">Register</a></li>
                ';
        }
      ?>
      </li>
      <li>
      <?php
		  	if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
              {
                  echo '<a href="../user/camera.php">Camera</a>';
              }
            else{
                echo '';
            }
      ?>
      </li>
      <li>
      <?php
		  	if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
              {
                  echo '<a href="../user/logout.php">Logout</a>';
              }
            else{
                echo '';
            }
		  ?>
    </li>
    </ul>
  </nav>
</header>


