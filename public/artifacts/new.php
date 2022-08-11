<?php
require_once('../../artifacts_private/initialize.php');
require_login();

if(is_post_request()) {

  $object = [];
  $object['Title'] = $_POST['Title'] ?? '';
  $object['Acq'] = $_POST['Acq'] ?? '';
  $object['type'] = $_POST['type'] ?? '';
  $object['KeptCol'] = $_POST['KeptCol'] ?? '';

  $result = insert_game($object);
  if($result === true) {
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'The object was created successfully.';
    redirect_to(url_for('/artifacts/show.php?id=' . $new_id));
  } else {
    $errors = $result;
  }

} else {
  // display the blank form
  $object = [];
  $object["Title"] = '';
  $object["type"] = '';
  $object["Acq"] = '';
  $object["KeptCol"] = '';
}
$page_title = 'Create object';
include(SHARED_PATH . '/header.php');
?>

<main>

  <li>
    <a class="back-link" href="<?php echo url_for('/artifacts/index.php'); ?>">&laquo; Artifacts</a>
  </li>
  <li>
    <a class="back-link" href="<?php echo url_for('/uses/create.php'); ?>">&laquo; Create Use</a>
  </li>

  <div class="object new">
    <h1>Create Artifact</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/artifacts/new.php'); ?>" method="post">

      <label for="Title">Name</label>
      <input type="text" name="Title" id="Title" value="<?php echo h($object['Title']); ?>" /></dd>
      
      <?php 
      $type = ''; 
      include(SHARED_PATH . '/artifact_type_select.php'); 
      ?>
      
      <label for="Acq">Acquisition Date</label>
      <input type="date" name="Acq" id="Acq" value="<?php echo date('Y') . '-' . date('m') . '-' . date('d'); ?>"/>

      <label for="KeptCol">Kept in Collection (Checked Means Yes)</label>
      <input type="hidden" name="KeptCol" value="0" />
      <input type="checkbox" name="KeptCol" value="1" checked/>

      <dl>
        <dt>Candidate?</dt>
        <dd>
          <input type="hidden" name="Candidate" value="0" />
          <input type="checkbox" name="Candidate" value="1"<?php if($game['Candidate'] == "1") { echo " checked"; } ?> />
        </dd>
      </dl>

      <div id="operations">
        <input type="submit" value="Create game" />
      </div>
    </form>

  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
