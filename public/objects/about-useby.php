<?php require_once('../../artifacts_private/initialize.php'); ?>
<?php require_login(); ?>
<?php $page_title = 'About Use By'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main>
  <p><a class="back-link" href="<?php echo url_for('/artifacts/useby.php'); ?>">&laquo; Back to Artifact Use List</a></p>
  <?php include(SHARED_PATH . '/about.html'); ?>
</main>

