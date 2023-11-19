<?php 

require_once('../../private/initialize.php');

require_login($_SERVER['REQUEST_URI']);

$page_title = '';

include(SHARED_PATH . '/header.php');

?>

<main>
  
  <h1><?php echo $page_title; ?></h1>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>