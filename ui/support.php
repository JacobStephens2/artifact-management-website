<?php // initialize page

  $page_title = 'Support';

  require_once('../private/initialize.php');

  require_login($_SERVER['REQUEST_URI']);

  include(SHARED_PATH . '/header.php');

?>

<main>

  <h1>
    <?php echo $page_title; ?>
  </h1>

    <p>Contact <?php echo DEV_NAME . ' at ' . DEV_EMAIL; ?> for support. </p>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>