<?php
  session_start();
  // store to test if they *were* logged in
  $old_user = $_SESSION['valid_user'];
  unset($_SESSION['valid_user']);
  session_destroy();
?>
<?php
  if (!empty($old_user))
  {
    header("Location: index.php");
  }
  else
  {
    // if they weren't logged in but came to this page somehow
    echo '<p>You were not logged in, and so have not been logged out.</p>';
  }
?>