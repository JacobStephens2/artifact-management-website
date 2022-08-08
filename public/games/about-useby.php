<?php require_once('../../artifacts_private/initialize.php'); ?>
<?php require_login(); ?>
<?php $page_title = 'About Use By'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main>
  <p><a class="back-link" href="<?php echo url_for('/objects/useby.php'); ?>">&laquo; Back to Use By list</a></p>
  <?php include(SHARED_PATH . '/about.html'); ?>
</main>

<?php include(SHARED_PATH . '/footer.php'); ?>