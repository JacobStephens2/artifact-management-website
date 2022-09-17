<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../../private/initialize.php');
require_login();
if(!isset($_GET['id'])) {
  redirect_to(url_for('/artifacts/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {
  // Handle form values sent by new.php
  $artifact = [];
  $artifact['id'] = $id ?? '';
  $artifact['Title'] = $_POST['Title'] ?? '';
  $artifact['Acq'] = $_POST['Acq'] ?? '';
  $artifact['type'] = $_POST['type'] ?? '';
  $artifact['KeptCol'] = $_POST['KeptCol'] ?? '';
  $artifact['Candidate'] = $_POST['Candidate'] ?? '';
  $artifact['UsedRecUserCt'] = $_POST['UsedRecUserCt'] ?? '';
  $artifact['MnP'] = $_POST['MnP'] ?? '';
  $artifact['MxP'] = $_POST['MxP'] ?? '';
  $artifact['SS'] = $_POST['SS'] ?? '';
  $result = update_artifact($artifact);
  if($result === true) {
    $_SESSION['message'] = 'The game was updated successfully.';
    redirect_to(url_for('/artifacts/edit.php?id=' . $id));
  } else {
    $errors = $result;
  }
} else {
  $artifact = find_game_by_id($id);
}
$page_title = h($artifact['Title']); 
include(SHARED_PATH . '/header.php'); 
?>

<main>

  <div class="object edit">
    <h1>Edit Artifact</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/artifacts/edit.php?id=' . h(u($id))); ?>" method="post">
      <label for="Title">Title</dt>
      <input type="text" name="Title" id="Title" value="<?php echo h($artifact['Title']); ?>" />

      <?php 
      $type = $artifact['type']; 
      require_once(SHARED_PATH . '/artifact_type_select.php'); 
      ?>

      <label for="SS">Sweet Spot</label>
      <input type="number" name="SS" id="SS" value="<?php echo $artifact['SS']; ?>">

      <label for="MnP">Minimum User Count</label>
      <input type="number" name="MnP" id="MnP" value="<?php echo $artifact['MnP']; ?>">

      <label for="MxP">Maximum User Count</label>
      <input type="number" name="MxP" id="MxP" value="<?php echo $artifact['MxP']; ?>">

      <label for="Acq">Acquisition Date</label>
      <input type="date" name="Acq" id="Acq" value="<?php echo h($artifact['Acq']); ?>" />
      
      <label for="KeptCol" >Kept in Collection? (Checked means yes)</label>
      <input type="hidden" name="KeptCol" value="0" />
      <input type="checkbox" name="KeptCol" id="KeptCol" value="1"<?php if($artifact['KeptCol'] == "1") { echo " checked"; } ?> />

      <label for="Candidate">Candidate?</label>
      <input type="text" name="Candidate" id="Candidate" value="<?php echo $artifact['Candidate'] ?>" />

      <label for="UsedRecUserCt">
        Used at recommended user count?<br/>
        Or fully used through at non recommended count? (Checked means yes)
      </label>
      <input type="hidden" name="UsedRecUserCt" value="0" />
      <input type="checkbox" name="UsedRecUserCt" id="UsedRecUserCt" value="1"<?php if($artifact['UsedRecUserCt'] == "1") { echo " checked"; } ?> />

      <input type="submit" value="Save Edits" />
    </form>

    <a class="action" href="<?php echo url_for('/artifacts/delete.php?id=' . h(u($_REQUEST['id']))); ?>">
      <p>Delete <?php echo h($artifact['Title']); ?></p>
    </a>

  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
