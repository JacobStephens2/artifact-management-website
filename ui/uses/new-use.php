<?php
require_once('../../private/initialize.php');
require_login();
$page_title = 'Record Use';
include(SHARED_PATH . '/header.php'); 
?>

<main>

  <?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process post request

    function insert_use($useArray) {
      // Sample argument structure
      // $use['user_ids'] = [1, 2];
      global $db;
      foreach($useArray as $use) {
        $sql = "INSERT INTO users_uses
          (user_id, use_id)
          VALUES
          ($user_id, $use_id)
        ";
        $result = mysqli_query($db, $sql);
      } 
    }

    // Then redirect user
    print_r($_POST);

  } else {
    // Redirect user
  }
  ?>
  
</main>

<?php include(SHARED_PATH . '/footer.php'); ?>