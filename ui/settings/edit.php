<?php 

require_once('../../private/initialize.php');

require_login();

$page_title = 'Edit User Settings';

$findUserSQL = "SELECT 
  first_name,
  last_name,
  email,
  username
  FROM users
  WHERE id = " . $_SESSION['user_id'] . "
;";

$userResult = mysqli_query($db, $findUserSQL);

$userArray = mysqli_fetch_assoc($userResult);

?>

<?php include(SHARED_PATH . '/header.php'); ?>

<main>

  <?php  
  if(is_post_request()) {
    echo '<pre>';
      print_r($_POST);
    echo '</pre>';
  }
  ?>
  
  <h1><?php echo $page_title; ?></h1>

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

    <input type="submit" value="Update Settings">
  </form>

  <a href="<?php echo url_for('/reset-password/index.php'); ?>">
    <p>Reset password</p>
  </a>


</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
