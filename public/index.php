<?php require_once('../artifacts_private/initialize.php'); ?>

<?php 
require_login();
?>

<?php $page_title = 'Menu'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>
<main>
  <div id="main-menu">
    <h2>Main Menu</h2>
    <ul>
      <li class="main-menu"><a href="<?php echo url_for('/games/index.php');?>">Artifacts</a></li>
      <li class="main-menu list-2">
        <a class="action" href="<?php echo url_for('/games/new.php'); ?>">Create New Artifact</a>
      </li>
      <li class="main-menu list-2"><a href="<?php echo url_for('/players/index.php');?>">Users</a></li>
      <li class="main-menu list-2">
        <a class="action" href="<?php echo url_for('/players/new.php'); ?>">Add New User</a>
      </li>
      <li class="main-menu list-2"><a href="<?php echo url_for('/games/responses.php');?>">Uses</a></li>
      <li class="main-menu list-2"><a href="<?php echo url_for('/games/response-new.php');?>">Record Use</a></li>
      <li class="main-menu list-2"><a href=" <?php echo url_for('/games/playby.php');?>">Use Artifacts by Date List</a></li>
      <li class="main-menu list-2"><a href="<?php echo url_for('/games/playgroup.php');?>">User Group</a></li>
      <li class="main-menu list-2"><a class="action" href="<?php echo url_for('/games/playgroup-choose.php'); ?>">Choose Games for User Group</a></li>
      <li class="main-menu list-2"><a href=" <?php echo url_for('/explore/index.php');?>">Explore Artifacts by Characteristic</a></li>

      <li class="main-menu"><a href="<?php echo url_for('/uses/new.php'); ?>">Record Use v2</a></li>
      <li class="main-menu"><a href="<?php echo url_for('/reset/index.php'); ?>">Reset password</a></li>

      <h2>Archived Menu</h2>
      <li class="main-menu"><a href="<?php echo url_for('/objects/index.php'); ?>">Objects</a></li>
      <li class="main-menu list-2"><a href="<?php echo url_for('/object_uses/new.php'); ?>">Record Use</a></li>
      <li class="main-menu list-2"><a href="<?php echo url_for('/object_uses/index.php'); ?>">Uses</a></li>
      <li class="main-menu list-2"><a href="<?php echo url_for('/objects/useby.php'); ?>">Use Artifacts by Date List</a></li>
    </ul>

    <p>You can use this site to generate a list of use-by dates for objects. <a href="https://jacobstephens.net" target="_blank">Jacob Stephens</a> uses this tool to track usage of their books, ensuring they use each book either in the next or previous 180 days. <a href="https://www.theminimalists.com/ninety/" target="_blank">The Minimalists' 90/90 Rule</a> inspired Jacob to create this tool.</p>

  </div>

</main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
