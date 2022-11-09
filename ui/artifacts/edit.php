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
  $artifact['Acq'] = $_POST['Acq'] ?? date('Y-m-d');
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
  $result = update_artifact($artifact);
  if($result === true) {
    $_SESSION['message'] = 'The artifact was updated successfully.';
    redirect_to(url_for('/artifacts/edit.php?id=' . $id));
  } else {
    $errors = $result;
  }
  $artifact = find_game_by_id($id);
} else {
  $artifact = find_game_by_id($id);
}

$sweetSpotsSQL = "SELECT
  sweetspots.id AS id,
  games.Title AS Title,
  sweetspots.SwS AS SwS
  FROM sweetspots
  JOIN games ON games.id = sweetspots.Title
  WHERE sweetspots.Title = " . $id . "
  ORDER BY games.Title ASC
";

$sweetSpotsResultObject = mysqli_query($db, $sweetSpotsSQL);

$page_title = h($artifact['Title']); 
include(SHARED_PATH . '/header.php'); 
?>

<main>

  <div class="object edit">
    <h1>Edit <?php echo h($artifact['Title']); ?></h1>

    <?php echo display_errors($errors); ?>

    <button id="editFormDisplayButton">
      Toggle Edit Form Display
    </button>

    <form 
      action="<?php echo url_for('/artifacts/edit.php?id=' . h(u($id))); ?>" 
      method="post"
      id="editForm"
      >
      <label for="Title">Title</dt>
      <input type="text" name="Title" id="Title" value="<?php echo h($artifact['Title']); ?>" />

      <?php 
      $type = $artifact['type']; 
      require_once(SHARED_PATH . '/artifact_type_select.php'); 
      ?>

      <label for="SS">Sweet Spot(s)</label>
      <input type="text" name="SS" id="SS" value="<?php echo $artifact['SS']; ?>">

      <?php 
      if (SWEET_SPOT_BUTTONS_ON == true) {
        ?>
        <section id="sweetSpots">
          <?php
          $i = 0;
          foreach ($sweetSpotsResultObject as $row) {
            ?>
            <div>
              <input 
                class="sweetSpot"
                type="number" 
                name="SwS[<?php echo $i; ?>]" 
                id="SS<?php echo $row['id']; ?>" 
                value="<?php echo $row['SwS']; ?>"
              >
              <button class="sweetSpot">-</button>
            </div>
            <?php
            $i++;
          }
          ?>
        </section>
        <button 
          id="addSweetSpot"
          class="sweetSpot"
          style="display: block;"
          >
          +
        </button>
        <?php
      }
      ?>

      <script defer src="edit.js"></script>

      <label for="MnP">Minimum User Count</label>
      <input type="number" name="MnP" id="MnP" value="<?php echo $artifact['MnP']; ?>">

      <label for="MxP">Maximum User Count</label>
      <input type="number" name="MxP" id="MxP" value="<?php echo $artifact['MxP']; ?>">

      <label for="MnT">Minimum Time</label>
      <input type="number" name="MnT" id="MnT" value="<?php echo $artifact['MnT']; ?>">

      <label for="MxT">Maxiumum Time</label>
      <input type="number" name="MxT" id="MxT" value="<?php echo $artifact['MxT']; ?>">

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

      <?php 
      if (!isset($artifact['Notes'])) { 
        $artifact['Notes'] = '';
      }
      ?>

      <label for="Notes">Notes</label>
      <textarea 
        name="Notes" 
        id="Notes" 
        cols="30" 
        rows="10"
        ><?php echo h($artifact['Notes']); ?></textarea>

      <input type="submit" value="Save Edits" />
    </form>

  </div>

  <section>
    <?php
    $findUsesOfArtifactByUserSQL = "SELECT
      responses.PlayDate,
      responses.id
      FROM responses
      WHERE responses.Title = " . $artifact['id'] . "
      AND responses.Player = " . $_SESSION['player_id'] . "
      ORDER BY responses.PlayDate DESC
    ";
    $usesOfArtifactByUserResultObject = mysqli_query($db, $findUsesOfArtifactByUserSQL);
    ?>
    <h2>
      You have recorded
      <?php echo $usesOfArtifactByUserResultObject->num_rows; ?> 
      uses of
      <?php echo h($artifact['Title']); ?>
    </h2>
    <table>
      <tr>
        <th>Use Date (<?php echo $usesOfArtifactByUserResultObject->num_rows; ?>)</th>
      <tr>
      <?php foreach ($usesOfArtifactByUserResultObject as $usesOfArtifactByUserArray) { ?>        
        <tr>
          <td>
            <a href="/uses/edit.php?id=<?php echo $usesOfArtifactByUserArray['id']; ?>">
              <?php echo $usesOfArtifactByUserArray['PlayDate']; ?>
            </a>
          </td>
        </tr>
      <?php } ?>
    </table>
  </section>

  <p>
    <a class="action" href="<?php echo url_for('/artifacts/delete.php?id=' . h(u($_REQUEST['id']))); ?>">
      Delete 
      <?php echo h($artifact['Title']); ?>
    </a>
  </p>

</main>

<script>
  let editForm = document.querySelector('#editForm');

  function toggleEditFormDisplay() {
    if (editForm.style.display == 'none') {
        editForm.style.display = 'block';
    } else {
        editForm.style.display = 'none';
    }
  }

  let editFormDisplayButton = document.querySelector('#editFormDisplayButton');

  editFormDisplayButton.addEventListener('click', toggleEditFormDisplay);
</script>

<?php include(SHARED_PATH . '/footer.php'); ?>
