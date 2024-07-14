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
      $type = $_SESSION['type'];
    } else {

      include(SHARED_PATH . '/artifact_type_array.php'); 
      global $typesArray;
      $type = $typesArray;
    }
  }
  $interval = $_POST['interval'] ?? DEFAULT_USE_INTERVAL;
  $sweetSpotFilter = $_POST['sweetSpotFilter'] ?? '';
  $showAttributes = $_POST['showAttributes'] ?? 'no';
  $artifact_set = find_games_by_user_id($kept, $type, $interval, $sweetSpotFilter);
  $page_title = 'Artifacts';
  if ($kept === 'secondary_only') { $page_title .= ' (Secondary Only)'; }
  include(SHARED_PATH . '/header.php'); 
  include(SHARED_PATH . '/dataTable.html');

?>

<script defer src="/shared/filter_button.js"></script>

<main>
  <div class="objects listing">

    <div style="display: flex;
      justify-content: space-between;"
      >
      <h1>Artifacts <?php if ($kept === 'secondary_only') { echo ' (Secondary Only)'; } ?></h1>
      <button id="display_filters" style="display: block">Show filters</button>
    </div>

    <form action="<?php echo url_for('/artifacts/index.php'); ?>" 
      method="post"
      style="display: none"
      >
      <label for="type">Game type</label>
      <select name="type" id="type">
        <option value="1" <?php if ($type == 1) { echo 'selected'; } ?>>All types</option>
        <?php require_once(SHARED_PATH . '/artifact_type_options.php'); ?>
      </select>
      
      <label for="sweetSpotFilter">Sweet Spot (SwS)</label>
      <input type="text" id="sweetSpotFilter" name="sweetSpotFilter"
        <?php 
          if (isset($_POST['sweetSpotFilter'])) {
            echo 'value="' . $_POST['sweetSpotFilter'] . '"';
          }
        ?>
      >

      <label for="showAttributes">Show artifact attributes</label>
      <input type="hidden" name="showAttributes" value="no">
      <input type="checkbox" name="showAttributes" id="showAttributes" value="yes"
        <?php 
          if ($showAttributes === 'yes') {
            echo ' checked ';
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

        <div style="margin-top: 1.6rem">
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
        
        <div>
          <label for="notkept">Show Secondary Collection Only</label>
          <input type="radio" name="kept" value="secondary_only" id="secondary_only"
          <?php 
            if ($kept === 'secondary_only') {
              echo ' checked ';
            }
          ?>
          >
        </div>

      </section>

      <input type="submit" value="Submit" />
    </form>

  	<table class="list" id="artifacts" data-page-length='100'>
      <thead>
        <tr id="headerRow">
          <th>Type</th>
          <th>Name (<?php echo $artifact_set->num_rows; ?>)</th>
          <th>Acquisition</th>
          <th>Recent Use</th>
          <th>Use By</th>
          <th>Kept</th>
          <?php
            if ($showAttributes === 'yes') {
              ?>
              <th>SwS</th>
              <th>AvgT</th>
              <th class="tooltip" title="Candidate">Candidate</th>
              <?php
            }
          ?>
        </tr>
      </thead>

      <style>
        .tooltip:hover {
          background: black;
        }
      </style>

      <tbody>
        <?php while($artifact = mysqli_fetch_assoc($artifact_set)) { ?>
          <tr>
            <td><?php echo h($artifact['type']); ?></td>

            <td>
              <a class="table-action" 
                href="<?php echo url_for('/artifacts/edit.php?id=' . h(u($artifact['id']))); ?>"
                >  
                <?php echo h($artifact['Title']); ?>
              </a>
            </td>

            <td class="date acquisition"><?php echo h($artifact['Acq']); ?></td>
            
            <td class="date most_recent_use">
              <?php 
                
                if ($artifact['MaxPlay'] > $artifact['MaxUse']) {
                  $most_recent_use = $artifact['MaxPlay']; 
                } else {
                  $most_recent_use = $artifact['MaxUse']; 
                }
                echo h($most_recent_use);
              ?>
            </td>

            <td class="date use_by"
              <?php 
                if ($most_recent_use === NULL) {
                  $conditional_interval = $interval;
                  $starting_date = $artifact['Acq'];
                } else {
                  $conditional_interval = $interval * 2;
                  $starting_date = $most_recent_use;
                }
                $use_by = date("Y-m-d", strtotime("$most_recent_use + $conditional_interval days"));
                
                if ($artifact['UseBy'] < date('Y-m-d') && $artifact['KeptCol'] == 1) {
                  echo " style='color:red;' ";
                }; 
              ?>
              >
              <?php echo h($use_by . " ($conditional_interval days added to $starting_date)"); ?>
            </td>

            <td class="kept">
              <?php 
                if ($artifact['KeptCol'] == 1) {
                  echo 'yes';
                } else {
                  echo 'no';
                }
              ?>
            </td>

            <?php
              if ($showAttributes === 'yes') {
                ?>
                <td>
                  <?php echo $artifact['ss']; ?>
                </td>
    
                <td>
                  <?php 
                    $avg_time = ($artifact['mnt'] + $artifact['mxt']) / 2;
                    echo h(ceil($avg_time)); 
                  ?>
                </td>

                <td>
                  <?php 
                  
                  if ($artifact['Candidate'] != '' && $artifact['Candidate'] != 0) { 
                    echo 'Yes'; 
                  } else {
                    echo 'No';
                  }
                  ?>
                </td>
                <?php
              }
            ?>
            
          </tr>
        <?php } ?>
      </tbody>
  	</table>

    <?php mysqli_free_result($artifact_set); ?>

    <script>
      let table = new DataTable('#artifacts', {
        // options
        order: [
          [ 2, 'desc'], // most recent acquisition first
          [ 3, 'desc'], // most recent use first
          [ 4, 'desc'], // most recent use by first
        ], 
      });

      document.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
          event.preventDefault();
          document.querySelector('form').submit();
        }
      })
    </script>
  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
