<?php
require_once('../../private/initialize.php');
require_login();

$defaultMnT = 30;
$defaultMxT = 60;
$defaultMnP = 1;
$defaultMxP = 1;
$defaultSS = '01';

$user_id = $_SESSION['user_id'];
$default_interval = singleValueQuery(
  "SELECT default_use_interval
  FROM users
  WHERE id = '$user_id'
");

if(is_post_request()) {

  $artifact = [];
  $artifact['Title'] = $_POST['Title'] ?? '';
  $artifact['Acq'] = $_POST['Acq'] ?? '';
  $artifact['type'] = $_POST['type'] ?? '';
  $artifact['KeptCol'] = $_POST['KeptCol'] ?? '';
  $artifact['Candidate'] = $_POST['Candidate'] ?? '';
  $artifact['interaction_frequency_days'] = $_POST['interaction_frequency_days'] ?? $default_interval;
  $artifact['CandidateGroupDate'] = date('Y-m-d');
  $artifact['UsedRecUserCt'] = 0;
  $artifact['Notes'] = $_POST['Notes'] ?? '';
  ($_POST['MnT'] == '') ? $artifact['MnT'] = $defaultMnT : $artifact['MnT'] = $_POST['MnT'];
  ($_POST['MxT'] == '') ? $artifact['MxT'] = $defaultMxT : $artifact['MxT'] = $_POST['MxT'];
  ($_POST['MnP'] == '') ? $artifact['MnP'] = $defaultMnP : $artifact['MnP'] = $_POST['MnP'];
  ($_POST['MxP'] == '') ? $artifact['MxP'] = $defaultMxP : $artifact['MxP'] = $_POST['MxP'];
  ($_POST['SS'] == '') ? $artifact['SS'] = $defaultSS : $artifact['SS'] = $_POST['SS'];

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
  $artifact["MnT"] = $defaultMnT;
  $artifact["MxT"] = $defaultMxT;
  $artifact["MnP"] = $defaultMnP;
  $artifact["MxP"] = $defaultMxP;
  $artifact["SS"] = $defaultSS;
}

$page_title = 'Create Artifact';
include(SHARED_PATH . '/header.php');

?>

<main>

  <div class="object new">
    <h1>Create Artifact</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/artifacts/new'); ?>" method="POST">

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

      <label for="interaction_frequency_days">Interaction Frequency (Days)</label>
      <input type="number" step="0.1" name="interaction_frequency_days" id="interaction_frequency_days"
        value="<?php echo $default_interval; ?>"
        onwheel="this.blur()"
      >

      <label for="SS">Sweet Spot(s)</label>
      <input type="text" name="SS" id="SS" 
        value="<?php echo $artifact['SS']; ?>"
      >

      <label for="MnP">Minimum User Count</label>
      <input type="number" name="MnP" id="MnP" 
        value="<?php echo $artifact['MnP']; ?>"
      >

      <label for="MxP">Maximum User Count</label>
      <input type="number" name="MxP" id="MxP" value="<?php echo $artifact['MxP']; ?>">

      <label for="MnT">Minimum Time</label>
      <input type="number" name="MnT" id="MnT" value="<?php echo $artifact['MnT']; ?>">

      <label for="MxT">Maxiumum Time</label>
      <input type="number" name="MxT" id="MxT" value="<?php echo $artifact['MxT']; ?>">

      <label for="KeptCol">Kept in Collection (Checked Means Yes)</label>
      <input type="hidden" name="KeptCol" value="0" />
      <input type="checkbox" name="KeptCol" value="1" checked/>
      
      <label for="Notes">Notes</label>
      <textarea name="Notes" id="Notes" cols="30" rows="5"></textarea>

      <div id="operations">
        <input type="submit" value="Create Artifact" />
      </div>
    </form>

  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
