<div class="wrapper nav_row">
  <nav>
    <ul>
      <li><a href="index.php">Gallery</a></li>
      <li>
      <?php
		  	if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
        {
          echo '<a href="#">Your account</a>';
        }
        else{
          echo '<a href="#">Your account</a>
                <ul>
                  <li><a href="login.php">Login</a></li>
                  <li><a href="register.php">Register</a></li>
                </ul>';
        }
      ?>
      </li>
      <li>
      <?php
		  	if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
              {
                  echo '<a href="camera.php">Camera</a>';
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
                  echo '<a href="logout.php">Logout</a>';
              }
            else{
                echo '';
            }
		  ?>
    </li>
    </ul>
  </nav>
</div>