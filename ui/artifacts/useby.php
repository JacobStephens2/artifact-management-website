<?php 
require_once('../../private/initialize.php');
require_login();
$page_title = 'Use By';
include(SHARED_PATH . '/header.php');
$type = $_POST['type'] ?? '1';
$interval = $_POST['interval'] ?? '180';
$artifact_set = use_by($type, $interval);
?>

<main>

  <div id="imports">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
  </div>

  <h1>Use Artifacts by Date</h1>

  <a class="hideOnPrint" href="<?php echo url_for('/objects/about-useby.php'); ?>">Learn About Use-by Date Generation</a>
  
  <form action="<?php echo url_for('/artifacts/useby.php'); ?>" method="post">
      <div class="hideOnPrint">
        <label for="type">Artifact Type</label>
        <select name="type" id="type">
          <option value="1" <?php if ($type == 1) { echo 'selected'; } ?>>All types</option>
          <?php require_once(SHARED_PATH . '/artifact_type_options.php'); ?>
        </select>
      </div>

      <div class="displayOnPrint">
        <label for="interval">Interval in days from most recent or to upcoming use</label>
        <input type="number" name="interval" id="interval" value="<?php echo $interval ?>">
      </div>
      
      <input type="submit" value="Submit" class="hideOnPrint"/>
    </form>

  <p>C stands for Candidate</p>
  <p>U stands for used at recommended user count or used fully through at non-recommended count</p>
  <p>O stands for Overdue</p>

  <table id="useBy" class="list">
    <thead>
      <tr id="headerRow">
        <th>Name (<?php echo $artifact_set->num_rows; ?>)</th>
        <th>C</th>
        <th>U</th>
        <th>O</th>
        <th>Use By</th>
        <th class="hideOnPrint">Recent Use</th>
        <th>Type</th>
      </tr>
    </thead>

    <tbody>
      <?php while($artifact = mysqli_fetch_assoc($artifact_set)) { ?>
        <tr>
          <td class="edit">
            <a class="action edit" href="<?php echo url_for('/artifacts/edit.php?id=' . h(u($artifact['id']))); ?>">
            <?php echo h($artifact['Title']); ?></a>
            </a>
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

          <td 
            <?php 
                if ($artifact['PlayBy'] < date('Y-m-d')) {
                  echo 'style="color: red;"';
                }
            ?>
            >
            <?php 
                if ($artifact['PlayBy'] < date('Y-m-d')) {
                  echo 'Yes';
                } else {
                  echo 'No';
                }
              ?>
          </td>
          <td class="date"><?php echo h($artifact['PlayBy']); ?></td>
          <td class="date hideOnPrint"><?php echo h($artifact['MaxPlay']); ?></td>
          <td class="type"><?php echo h($artifact['type']); ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <?php mysqli_free_result($artifact_set); ?>

  <script>
    let table = new DataTable('#useBy', {
      // options
      order: [[ 4, 'asc']]
    });
  </script>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
