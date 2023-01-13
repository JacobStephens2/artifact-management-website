<?php 
  require_once('../../private/initialize.php');
  require_login();
  $kept = $_GET['kept'] ?? 'all';
  $type = $_POST['type'] ?? '1';
  $interval = $_POST['interval'] ?? '180';
  $artifact_set = find_games_by_user_id($kept, $type, $interval);
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
          <input type="number" name="interval" id="interval" value="<?php echo $interval ?>">
        </div>

        <input type="submit" value="Submit" />
      </form>

      <div>
      
        <?php // Artifact kept filters
          if ($kept != 'all') {
            ?>
              <li>
              <a href="<?php echo url_for("/artifacts/index.php?kept=all"); ?>">
                Show All Artifacts
              </a>
              </li>
            <?php
          } 
          if ( $kept != 'yes' ) {
            ?>
              <li>
              <a href="<?php echo url_for("/artifacts/index.php?kept=yes"); ?>">
                Show Only Artifacts Kept
              </a>
              </li>
            <?php
          }

          if ( $kept != 'no') {
            ?>
            <li>
            <a href="<?php echo url_for("/artifacts/index.php?kept=no"); ?>">
              Show Only Artifacts Not Kept
            </a>
            </li>
            <?php
          }
        ?>

        <p>C stands for candidate</p>
        <p>U stands for used at recommended user count or used fully through at non-recommended count</p>
        <p>O stands for overdue</p>

      </div>
    </section>

  	<table class="list" id="artifacts" data-page-length='100'>
      <thead>
        <tr id="headerRow">
          <th>Acquisition</th>
          <th>Type</th>
          <th>Kept</th>
          <th>O</th>
          <th>U</th>
          <th>C</th>
          <th>Name (<?php echo $artifact_set->num_rows; ?>)</th>
          <th>Acquisition Date</th>
          <th>Recent Use</th>
          <th>Use By</th>
        </tr>
      </thead>

      <tbody>
        <?php while($artifact = mysqli_fetch_assoc($artifact_set)) { ?>
          <tr>
            <td><?php echo h($artifact['Acq']); ?></td>
            
            <td><?php echo h($artifact['type']); ?></td>

            <td><?php echo $artifact['KeptCol'] == 1 ? 'Kept' : ''; ?></td>

            <td 
              <?php 
                  if ($artifact['UseBy'] < date('Y-m-d')) {
                    echo 'style="color: red;"';
                  }
              ?>
              >
              <?php 
                  if ($artifact['UseBy'] < date('Y-m-d')) {
                    echo 'Yes';
                  } else {
                    echo 'No';
                  }
              ?>
            </td>
            
            <td
              <?php 
                  if ( $artifact['UsedRecUserCt'] != 1 ) {
                    echo 'style="color: red;"';
                  }
              ?>
              >
              <?php 
              if ( $artifact['UsedRecUserCt'] != 1 ) {
                echo 'No';
              } else {
                echo 'Yes';
              } 
              ?>
            </td>

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
              <a class="table-action" href="<?php echo url_for('/artifacts/edit.php?id=' . h(u($artifact['id']))); ?>">  
                <?php echo h($artifact['Title']); ?>
              </a>
            </td>

            <td><?php echo h($artifact['Acq']); ?></td>

            <td class="date"><?php echo h($artifact['MaxPlay']); ?></td>
            
            <td class="date">
              <?php echo h($artifact['UseBy']); ?>
            </td>
            
          </tr>
        <?php } ?>
      </tbody>
  	</table>

    <?php mysqli_free_result($artifact_set); ?>

    <script>
      let table = new DataTable('#artifacts', {
        // options
        order: [[ 8, 'desc']]
      });
    </script>
  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
