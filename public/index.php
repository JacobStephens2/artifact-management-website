<?php require_once('../artifacts_private/initialize.php'); ?>

<?php 
require_login();
?>

<?php $page_title = 'Menu'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>
<div id="content">
  <div id="main-menu">
    <h2>Main Menu</h2>
    <ul>
      <li class="main-menu"><a href="<?php echo url_for('/objects/index.php'); ?>">Objects</a></li>
      <li class="main-menu list-2"><a href="<?php echo url_for('/object_uses/new.php'); ?>">Record use</a></li>
      <li class="main-menu list-2"><a href="<?php echo url_for('/object_uses/index.php'); ?>">Uses</a></li>
      <li class="main-menu list-2"><a href="<?php echo url_for('/objects/useby.php'); ?>">Use artifacts by date list</a></li>
      <li class="main-menu"><a href="<?php echo url_for('/reset/index.php'); ?>">Reset password</a></li>      
    </ul>

    <p>You can use this site to generate a list of use-by dates for objects. <a href="https://jacobcstephens.com" target="_blank">Jacob Stephens</a> uses this tool to track usage of their books, ensuring they use each book either in the next or previous 180 days. <a href="https://www.theminimalists.com/ninety/" target="_blank">The Minimalists' 90/90 Rule</a> inspired Jacob to create this tool.</p>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
