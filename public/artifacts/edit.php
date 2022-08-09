<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../../artifacts_private/initialize.php');
require_login();
if(!isset($_GET['id'])) {
  redirect_to(url_for('/artifacts/index.php'));
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
  $game['Candidate'] = $_POST['Candidate'] ?? '';
  $result = update_game($game);
  if($result === true) {
    $_SESSION['message'] = 'The game was updated successfully.';
    redirect_to(url_for('/artifacts/edit.php?id=' . $id));
  } else {
    $errors = $result;
  }
} else {
  $game = find_game_by_id($id);
}
$page_title = h($game['Title']); 
include(SHARED_PATH . '/header.php'); 
?>

<main>
  <li><a class="back-link" href="<?php echo url_for('/artifacts/useby.php'); ?>">&laquo; Use Artifacts By</a></li>
  <li><a class="back-link" href="<?php echo url_for('/artifacts/index.php'); ?>">&laquo; Artifacts</a></li>
  <li><a class="back-link" href="<?php echo url_for('/artifacts/new.php'); ?>">&laquo; New Artifact</a></li>
  <li><a class="back-link" href="<?php echo url_for('/artifacts/playgroup-choose.php'); ?>">&laquo; Choose for Group</a></li>
  <li><a class="back-link" href="<?php echo url_for('/uses/create.php'); ?>">&laquo; Record Use</a></li>

  <div class="object edit">
    <h1>Edit Artifact</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/artifacts/edit.php?id=' . h(u($id))); ?>" method="post">
      <label for="Title">Title</dt>
      <input type="text" name="Title" id="Title" value="<?php echo h($game['Title']); ?>" />

      <?php 
      $type = $game['type']; 
      require_once(SHARED_PATH . '/artifact_type_select.php'); 
      ?>

      <label for="Acq">Acquisition Date</label>
      <input type="date" name="Acq" id="Acq" value="<?php echo h($game['Acq']); ?>" />
      
      <label for="KeptCol" >Kept in Collection? (Checked Indicates Kept)</label>
      <input type="hidden" name="KeptCol" value="0" />
      <input type="checkbox" name="KeptCol" id="KeptCol" value="1"<?php if($game['KeptCol'] == "1") { echo " checked"; } ?> />

      <label for="Candidate">Candidate?</label>
      <input type="hidden" name="Candidate" value="0" />
      <input type="checkbox" name="Candidate" id="Candidate" value="1"<?php if($game['Candidate'] == "1") { echo " checked"; } ?> />

      <input type="submit" value="Save Edits" />
    </form>

    <a class="action" href="<?php echo url_for('/artifacts/delete.php?id=' . h(u($_REQUEST['id']))); ?>">
      <p>Delete <?php echo h($game['Title']); ?></p>
    </a>

  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
