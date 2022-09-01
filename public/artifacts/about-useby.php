<?php 
require_once('../../artifacts_private/initialize.php');
require_login();
$page_title = 'About Use By';
include(SHARED_PATH . '/header.php');
?>

<main>
  <p>
    <a class="back-link" href="<?php echo url_for('/artifacts/useby.php'); ?>">
      &laquo; Back to Use Artifacts By Date
    </a>
  </p>
  <?php include(SHARED_PATH . '/about.html'); ?>
</main>

<?php include(SHARED_PATH . '/footer.php'); ?>