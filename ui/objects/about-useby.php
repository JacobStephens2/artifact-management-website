<?php require_once('../../private/initialize.php'); ?>
<?php require_login($_SERVER['REQUEST_URI']); ?>
<?php $page_title = 'About Use By'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main>
  <p><a class="back-link" href="<?php echo url_for('/artifacts/useby.php'); ?>">&laquo; Back to Artifact Use List</a></p>
  <?php include(SHARED_PATH . '/about.html'); ?>
</main>

