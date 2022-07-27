<?php

require_once('../../artifacts_private/initialize.php');
require_login();

if(!isset($_GET['ID'])) {
  redirect_to(url_for('/games/playgroup.php'));
}
$ID = $_GET['ID'];

if(is_post_request()) {

  $result = delete_playgroup_player($ID);
  $_SESSION['message'] = 'The player was successfully removed from the playgroup.';
  redirect_to(url_for('/games/playgroup.php'));

} else {
  $object = find_playgroup_player_by_id($ID);
}

?>

<?php $page_title = 'Delete game'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main>

  <a class="back-link" href="<?php echo url_for('/games/playgroup.php'); ?>">&laquo; Playgroup</a>

  <div class="object delete">
    <h1>Remove player from playgroup</h1>
    <p>Are you sure you want to remove this player from the playgroup?</p>
    <p class="item"><?php echo h($object['FirstName']) . ' ' . h($object['LastName']); ?></p>

    <form action="<?php echo url_for('/games/playgroup-delete.php?ID=' . h(u($object['ID']))); ?>" method="post">
      <div ID="operations">
        <input type="submit" name="commit" value="Remove player from playgroup" />
      </div>
    </form>
  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
