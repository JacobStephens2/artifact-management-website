<?php

require_once('../../artifacts_private/initialize.php');
require_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/games/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  $result = delete_game($id);
  $_SESSION['message'] = 'The game was deleted successfully.';
  redirect_to(url_for('/games/index.php'));

} else {
  $object = find_game_by_id($id);
}

?>

<?php $page_title = 'Delete game'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/games/index.php'); ?>">&laquo; Games</a>

  <div class="object delete">
    <h1>Delete game</h1>
    <p>Are you sure you want to delete this game?</p>
    <p class="item"><?php echo h($object['Title']); ?></p>

    <form action="<?php echo url_for('/games/delete.php?id=' . h(u($object['id']))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete game" />
      </div>
    </form>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
