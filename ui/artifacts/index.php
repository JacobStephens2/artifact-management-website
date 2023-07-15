<?php 
  require_once('../../private/initialize.php');
  require_login();
  $kept = $_POST['kept'] ?? 'allkeptandnot';
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['type'])) {

      if ($_POST['type'] == '1') {
        $type = array('');
      } else {
        $type = $_POST['type'];
      }
    } else {
      $type = array();
    }
  } else {
    if (isset($_SESSION['type']) && count($_SESSION['type']) > 0) {
      echo __LINE__;
      $type = $_SESSION['type'];
    } else {
      echo __LINE__;

      include(SHARED_PATH . '/artifact_types_array.php'); 
      global $typesArray;
      $type = $typesArray;
    }
  }
  $interval = $_POST['interval'] ?? '182.5';
  $sweetSpotFilter = $_POST['sweetSpotFilter'] ?? '';
  $artifact_set = find_games_by_user_id($kept, $type, $interval, $sweetSpotFilter);
  $page_title = 'Artifacts';
  include(SHARED_PATH . '/header.php'); 
  include(SHARED_PATH . '/dataTable.html');

?>

<main>
  <div class="objects listing">
    <h1>Artifacts</h1>

    <section style="display: flex; column-gap: 3.9rem;">
      <form action="<?php echo url_for('/artifacts/index.php'); ?>" method="post">
        <label for="type">Game type</label>
        <select name="type" id="type">
          <option value="1" <?php if ($type == 1) { echo 'selected'; } ?>>All types</option>
          <?php require_once(SHARED_PATH . '/artifact_type_options.php'); ?>
        </select>
        
        <div class="displayOnPrint">
          <label for="interval">Interval in days from most recent or to upcoming use</label>
          <input type="number" name="interval" id="interval" value="<?php echo $interval ?>" step="0.1">
        </div>

        <label for="sweetSpotFilter">Sweet Spot (SwS)</label>
        <input type="text" id="sweetSpotFilter" name="sweetSpotFilter"
          <?php 
            if (isset($_POST['sweetSpotFilter'])) {
              echo 'value="' . $_POST['sweetSpotFilter'] . '"';
            }
          ?>
        >

        <label for="artifactType">Artifact type</label>
        <section id="artifactType" style="display: flex; flex-wrap: wrap">
          <?php require_once SHARED_PATH . '/artifact_type_checkboxes.php'; ?>
        </section>

        <section id="kept" style="margin-top: 1rem">
          <style>
            section#kept label,
            section#kept input {
              display: inline;
            }
          </style>

          <div>
            <label for="allkeptandnot">Show All Artifacts</label>
            <input type="radio" name="kept" value="allkeptandnot" id="allkeptandnot"
            <?php 
              if ($kept === 'allkeptandnot') {
                echo ' checked ';
              }
            ?>
            >
          </div>

          <div>
            <label for="onlykept">Show Only Artifacts Kept</label>
            <input type="radio" name="kept" value="yes" id="onlykept"
              <?php 
              if ($kept === 'yes') {
                echo ' checked ';
              }
              ?>
            >
          </div>

          <div>
            <label for="notkept">Show Only Artifacts Not Kept</label>
            <input type="radio" name="kept" value="no" id="notkept"
            <?php 
              if ($kept === 'no') {
                echo ' checked ';
              }
            ?>
            >
          </div>

        </section>

        <input type="submit" value="Submit" />
      </form>

      <div>
      
        <p>C stands for candidate</p>
        <p>U stands for used at recommended user count or used fully through at non-recommended count</p>
        <p>SwS stands for sweet spot</p>

      </div>
    </section>

  	<table class="list" id="artifacts" data-page-length='100'>
      <thead>
        <tr id="headerRow">
          <th>Type</th>
          <th>C</th>
          <th>SwS</th>
          <th>Name (<?php echo $artifact_set->num_rows; ?>)</th>
          <th>Acquisition Date</th>
          <th>Recent Use</th>
        </tr>
      </thead>

      <tbody>
        <?php while($artifact = mysqli_fetch_assoc($artifact_set)) { ?>
          <tr>
            <td><?php echo h($artifact['type']); ?></td>

            <td>
              <?php 
                  if ($artifact['Candidate'] < 1) {
                    echo '';
                  } else {
                    echo $artifact['Candidate'];
                  }
              ?>
            </td>
            
            <td>
              <?php echo $artifact['ss']; ?>
            </td>

            <td>
              <a class="table-action" href="<?php echo url_for('/artifacts/edit.php?id=' . h(u($artifact['id']))); ?>">  
                <?php echo h($artifact['Title']); ?>
              </a>
            </td>

            <td><?php echo h($artifact['Acq']); ?></td>

            <td class="date"><?php echo h($artifact['MaxPlay']); ?></td>
            
          </tr>
        <?php } ?>
      </tbody>
  	</table>

    <?php mysqli_free_result($artifact_set); ?>

    <script>
      let table = new DataTable('#artifacts', {
        // options
        order: [[ 5, 'desc']] // most recent use first
      });
    </script>
  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
