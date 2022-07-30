<?php

require_once('../../artifacts_private/initialize.php');
require_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/games/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  // Handle form values sent by new.php

  $game = [];
  $game['id'] = $id ?? '';
  $game['Title'] = $_POST['Title'] ?? '';
  $game['Acq'] = $_POST['Acq'] ?? '';
  $game['type'] = $_POST['type'] ?? '';
  $game['KeptCol'] = $_POST['KeptCol'] ?? '';

  $result = update_game($game);
  if($result === true) {
    $_SESSION['message'] = 'The game was updated successfully.';
    redirect_to(url_for('/games/edit.php?id=' . $id));
  } else {
    $errors = $result;
  }

} else {

  $game = find_game_by_id($id);

}

?>

<?php $page_title = 'Edit game'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main>

  <li><a class="back-link" href="<?php echo url_for('/games/index.php'); ?>">&laquo; Artifacts</a></li>
  <li><a class="back-link" href="<?php echo url_for('/games/playby.php'); ?>">&laquo; Use Artifacts By</a></li>
  <li><a class="back-link" href="<?php echo url_for('/games/playgroup-choose.php'); ?>">&laquo; Choose for Group</a></li>
  <li><a class="back-link" href="<?php echo url_for('/uses/create.php'); ?>">&laquo; Record Use</a></li>

  <div class="object edit">
    <h1>Edit Artifact</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/games/edit.php?id=' . h(u($id))); ?>" method="post">
      <dl>
        <dt>Title</dt>
        <dd><input type="text" name="Title" value="<?php echo h($game['Title']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Type</dt>
        <dd>
          <?php $type = $game['type']; ?>
          
          <select name="type">
            <option value="board-game" <?php if($type == 'board-game') { echo 'selected'; } ?>>Board Game</option>
            <option value="role-playing-game" <?php if($type == 'role-playing-game') { echo 'selected'; } ?>>Role Playing Game</option>
            <option value="video-game" <?php if($type == 'video-game') { echo 'selected'; } ?>>Video Game</option>
            <option value="sport" <?php if($type == 'sport') { echo 'selected'; } ?>>Sport</option>
            <option value="game" <?php if($type == 'game') { echo 'selected'; } ?>>Game</option>
            <option value="vr-game" <?php if($type == 'vr-game') { echo 'selected'; } ?>>VR Game</option>
            <option value="video" <?php if($type == 'video') { echo 'selected'; } ?>>Video</option>
            <option value="toy" <?php if($type == 'toy') { echo 'selected'; } ?>>Toy</option>
            <option value="mobile-game" <?php if($type == 'mobile-game') { echo 'selected'; } ?>>Toy</option>
          </select>

        </dd>
      <dl>
        <dt>Acquisition Date</dt>
        <dd><input type="date" name="Acq" value="<?php echo h($game['Acq']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Kept in Collection? (Checked Indicates Kept)</dt>
        <dd>
          <input type="hidden" name="KeptCol" value="0" />
          <input type="checkbox" name="KeptCol" value="1"<?php if($game['KeptCol'] == "1") { echo " checked"; } ?> />
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Save Edits" />
      </div>
    </form>

    <a class="action" href="<?php echo url_for('/games/delete.php?id=' . h(u($_REQUEST['id']))); ?>">
      <p>Delete <?php echo h($game['Title']); ?></p>
    </a>

  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
