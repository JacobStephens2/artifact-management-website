<?php
require_once('../../private/initialize.php');
require_login();

if(is_post_request()) {

  $artifact = [];
  $artifact['Title'] = $_POST['Title'] ?? '';
  $artifact['Acq'] = $_POST['Acq'] ?? '';
  $artifact['type'] = $_POST['type'] ?? '';
  $artifact['KeptCol'] = $_POST['KeptCol'] ?? '';
  $artifact['Candidate'] = $_POST['Candidate'] ?? '';
  $artifact['UsedRecUserCt'] = $_POST['UsedRecUserCt'] ?? '';
  $artifact['Notes'] = $_POST['Notes'] ?? '';
  ($_POST['MnT'] == '') ? $artifact['MnT'] = 5 : $artifact['MnT'] = $_POST['MnT'];
  ($_POST['MxT'] == '') ? $artifact['MxT'] = 240 : $artifact['MxT'] = $_POST['MxT'];
  ($_POST['MnP'] == '') ? $artifact['MnP'] = 5 : $artifact['MnP'] = $_POST['MnP'];
  ($_POST['MxP'] == '') ? $artifact['MxP'] = 240 : $artifact['MxP'] = $_POST['MxP'];
  ($_POST['SS'] == '') ? $artifact['SS'] = 1 : $artifact['SS'] = $_POST['SS'];

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
      
      <label for="type">Type</label>
      <select name="type" id="type">
        <?php 
        $type = $artifact['type']; 
        require_once(SHARED_PATH . '/artifact_type_options.php'); 
        ?>
      </select>
      
      <label for="Acq">Acquisition Date</label>
      <input type="date" name="Acq" id="Acq" value="<?php 
      $tz = 'America/New_York';
      $timestamp = time();
      $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
      $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
      echo $dt->format('Y') . '-' . $dt->format('m') . '-' . $dt->format('d'); 
      ?>"/>

      <label for="SS">Sweet Spot(s)</label>
      <input type="text" name="SS" id="SS" value="">

      <label for="MnP">Minimum User Count</label>
      <input type="number" name="MnP" id="MnP" value="">

      <label for="MxP">Maximum User Count</label>
      <input type="number" name="MxP" id="MxP" value="">

      <label for="MnT">Minimum Time</label>
      <input type="number" name="MnT" id="MnT" value="">

      <label for="MxT">Maxiumum Time</label>
      <input type="number" name="MxT" id="MxT" value="">

      <label for="KeptCol">Kept in Collection (Checked Means Yes)</label>
      <input type="hidden" name="KeptCol" value="0" />
      <input type="checkbox" name="KeptCol" value="1" checked/>
      
      <label for="Candidate">Candidate?</label>
      <input type="text" name="Candidate" id="Candidate" value="<?php echo $artifact['Candidate']; ?>" />

      <label for="UsedRecUserCt">Used at recommended user count or completely through at non recommended user count</label>
      <input type="hidden" name="UsedRecUserCt" value="0" />
      <input type="checkbox" name="UsedRecUserCt" value="1" checked/>

      <label for="Notes">Notes</label>
      <textarea name="Notes" id="Notes" cols="30" rows="5"></textarea>

      <div id="operations">
        <input type="submit" value="Create Artifact" />
      </div>
    </form>

  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
