<?php
require_once('../../artifacts_private/initialize.php');
require_login();

if(is_post_request()) {

  $artifact = [];
  $artifact['Title'] = $_POST['Title'] ?? '';
  $artifact['Acq'] = $_POST['Acq'] ?? '';
  $artifact['type'] = $_POST['type'] ?? '';
  $artifact['KeptCol'] = $_POST['KeptCol'] ?? '';
  $artifact['Candidate'] = $_POST['Candidate'] ?? '';
  $artifact['UsedRecUserCt'] = $_POST['UsedRecUserCt'] ?? '';

  $result = insert_game($artifact);
  if($result === true) {
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'The object was created successfully.';
    redirect_to(url_for('/artifacts/show.php?id=' . $new_id));
  } else {
    $errors = $result;
  }

} else {
  // display the blank form
  $artifact = [];
  $artifact["Title"] = '';
  $artifact["type"] = '';
  $artifact["Acq"] = '';
  $artifact["KeptCol"] = '';
  $artifact["Candidate"] = '';
  $artifact["UsedRecUserCt"] = '';
}

$page_title = 'Create Artifact';
include(SHARED_PATH . '/header.php');
?>

<main>

  <div class="object new">
    <h1>Create Artifact</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/artifacts/new.php'); ?>" method="post">

      <label for="Title">Name</label>
      <input type="text" name="Title" id="Title" value="<?php echo h($artifact['Title']); ?>" /></dd>
      
      <?php 
      $type = ''; 
      include(SHARED_PATH . '/artifact_type_select.php'); 
      ?>
      
      <label for="Acq">Acquisition Date</label>
      <input type="date" name="Acq" id="Acq" value="<?php echo date('Y') . '-' . date('m') . '-' . date('d'); ?>"/>

      <label for="KeptCol">Kept in Collection (Checked Means Yes)</label>
      <input type="hidden" name="KeptCol" value="0" />
      <input type="checkbox" name="KeptCol" value="1" checked/>
      
      <label for="Candidate">Candidate?</label>
      <input type="text" name="Candidate" id="Candidate" value="<?php echo $artifact['Candidate']; ?>" />

      <label for="UsedRecUserCt">Used at recommended user count or completely through at non recommended user count</label>
      <input type="hidden" name="UsedRecUserCt" value="0" />
      <input type="checkbox" name="UsedRecUserCt" value="1" checked/>

      <div id="operations">
        <input type="submit" value="Create Artifact" />
      </div>
    </form>

  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
