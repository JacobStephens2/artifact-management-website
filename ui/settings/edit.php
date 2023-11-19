<?php 

require_once('../../private/initialize.php');
global $db;

require_login();

$page_title = 'Edit User Settings';

if(is_post_request()) {
  $query = "UPDATE users
    SET first_name = '" . db_escape($db, $_POST['first_name']) . "',
      last_name = '" . db_escape($db, $_POST['last_name']) . "',
      email = '" . db_escape($db, $_POST['email']) . "',
      username = '" . db_escape($db, $_POST['username']) . "',
      default_use_interval  = '" . db_escape($db, $_POST['default_use_interval']) . "'
      WHERE id = " . $_SESSION['user_id'] . "
      LIMIT 1
  ";
  $update_result = query($query);
}

$findUserSQL = "SELECT 
  first_name,
  last_name,
  email,
  username,
  default_use_interval
  FROM users
  WHERE id = " . $_SESSION['user_id'] . "
;";

$userResult = mysqli_query($db, $findUserSQL);

$userArray = mysqli_fetch_assoc($userResult);

?>

<?php include(SHARED_PATH . '/header.php'); ?>

<main>
  
  <h1><?php echo $page_title; ?></h1>

  <?php
      if (isset($update_result) && $update_result === false) {
        echo '<p>Update failed, please contact support</p>';
      } elseif (isset($update_result) && $update_result === true) {
        echo '<p>Update successful</p>';
      }
  ?>

  <form method='POST'>
    <label for="first_name">First Name</label>
    <input 
      type="text" 
      name="first_name" 
      id="first_name" 
      value="<?php echo $userArray['first_name']; ?>"
    >

    <label for="last_name">Last Name</label>
    <input 
      type="text" 
      name="last_name" 
      id="last_name"
      value="<?php echo $userArray['last_name']; ?>"
    >

    <label for="email">Email</label>
    <input 
      type="email" 
      name="email" 
      id="email"
      value="<?php echo $userArray['email']; ?>"
    >

    <label for="username">Username</label>
    <input 
      type="text" 
      name="username" 
      id="username"
      value="<?php echo $userArray['username']; ?>"
    >
    
    <label for="default_use_interval">Default Use Interval</label>
    <input 
      type="number" 
      step="0.1"
      name="default_use_interval" 
      id="default_use_interval"
      value="<?php echo $userArray['default_use_interval']; ?>"
    >

    <input type="submit" value="Update Settings">
  </form>

  <a href="<?php echo url_for('/reset-password/index.php'); ?>">
    <p>Reset password</p>
  </a>


</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
