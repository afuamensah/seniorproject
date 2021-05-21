<?php
session_start();

if (isset($_POST['email']) && isset($_POST['password']))
{
  // if the user has just tried to log in
  $email = $_POST['email'];
  $password = $_POST['password'];
  $password = hash('sha256', $password);

  require('dbconnect.php');

  $db_conn = @new mysqli($db_server, $db_username, $db_password, $db_name);

  if (mysqli_connect_errno()) {
    echo 'Connection to database failed:'.mysqli_connect_error();
    exit();
  }

  $query = "SELECT * from admin where email ='$email' and password ='$password'";

  $result = $db_conn->query($query);
  if ($result->num_rows)
  {
    while ($row = $result->fetch_assoc()) {
      $name = $row['name'];
    }
    $_SESSION['valid_user'] = $name;
  }
  $db_conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css" type="text/css">
		<title>Herdr - Admin</title>
    </head>
    <body>
        <div class="container login">
        <img src="../img/logo.png" class="logo">
        <h1>Herdr Admin Login</h1>
        <br>
    <?php
      if (isset($_SESSION['valid_user']))
      {
        header("Location: dashboard.php");
      }
      else
      {
        if (isset($email))
        {
          // if they've tried and failed to log in
          echo '<p class="message">Could not log you in with the credentials used. Please try again.</p>';
        }
        else
        {
          // they have not tried to log in yet or have logged out
          echo '<p class="message">Please sign in using your Lipscomb account.</p>';
        }

        // provide form to log in
        echo '<form action="index.php" method="post">';
        echo '<div class="form-group">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="email" placeholder="Enter Lipscomb E-mail..."></input>
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password" placeholder="Enter Password..."></input>
            </div>
          </div>';
        echo '<input type="submit" class="log btn btn-dark unread" name="login" value="Login">';
        echo '</form>';

      }
    ?>
</div>
</body>
</html>
    