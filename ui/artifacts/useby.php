<?php 
  require_once('../../private/initialize.php');
  require_login();
  $page_title = 'Use By';
  include(SHARED_PATH . '/header.php');
  include(SHARED_PATH . '/dataTable.html'); 
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['type'])) {
      $type = $_POST['type'];
    } else {
      $type = [];
    }
  } else {
    if (isset($_SESSION['type']) && count($_SESSION['type']) > 0) {
      $type = $_SESSION['type'];
    } else {
      echo SHARED_PATH;
      include(SHARED_PATH . '/artifact_type_array.php'); 
      global $typesArray;
      $type = $typesArray;
    }
  }
  $_SESSION['type'] = $type;
  $sweetSpot = $_POST['sweetSpot'] ?? '';
  $shelfSort = $_POST['shelfSort'] ?? 'no';
  $typeArray = $_SESSION['type'] ?? [];
  $interval = $_POST['interval'] ?? 183;
  $artifact_set = use_by($type, $interval, $sweetSpot);
?>

<main>

  <h1>Use Artifacts by Date</h1>

  <a class="hideOnPrint" href="<?php echo url_for('/objects/about-useby.php'); ?>">Learn About Use-by Date Generation</a>
  
  <div id="intro">
    <form action="<?php echo url_for('/artifacts/useby.php'); ?>" method="post">
      <div class="hideOnPrint">

        <label for="artifactType">Artifact type</label>
        <section id="artifactType" style="display: flex; flex-wrap: wrap">
          <?php require_once '../../private/shared/artifact_type_checkboxes.php'; ?>
        </section>

        <label for="sweetSpot">Sweet Spot</label>
        <input type="number" name="sweetSpot" id="sweetSpot" value="<?php echo $sweetSpot; ?>">
       
        <label for="shelfSort">Shelf Sort (Instead of Use By Sort)</label>
        <input type="hidden" name="shelfSort" value="no">
        <input type="checkbox" name="shelfSort" id="shelfSort" value="yes"
          <?php 
            if ($shelfSort === 'yes') {
              echo ' checked ';
            }
          ?>
        >

      </div>


      <div class="displayOnPrint">
        <label for="interval">Interval in days from most recent or to upcoming use</label>
        <input type="number" name="interval" id="interval" value="<?php echo $interval ?>">
      </div>
      
      <input type="submit" value="Submit" class="hideOnPrint"/>
    </form>

    <section id="legend">
      <p>C stands for Candidate</p>
      <p>U stands for used at recommended user count or used fully through at non-recommended count</p>
      <p>O stands for Overdue</p>
    </section>
  </div>

  <table id="useBy" class="list" data-page-length='100'>
    <thead>
      <tr id="headerRow">
        <th>Name (<?php echo $artifact_set->num_rows; ?>)</th>
        <th>SS</th>
        <th>MnP</th>
        <th>MxP</th>
        <th>MnT</th>
        <th>MxT</th>
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
          
          <td><?php echo h($artifact['ss']); ?></td>
          <td><?php echo h($artifact['mnp']); ?></td>
          <td><?php echo h($artifact['mxp']); ?></td>
          <td><?php echo h($artifact['mnt']); ?></td>
          <td><?php echo h($artifact['mxt']); ?></td>
          
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
                date_default_timezone_set('America/New_York');
                $DateTimeNow = new DateTime(date('Y-m-d')); 
                $DateTimePlayBy = new DateTime(substr($artifact['PlayBy'],0,10)); 

                if ($DateTimePlayBy < $DateTimeNow) {
                  echo 'style="color: red;"';
                }
            ?>
            >
            <?php 
                if ($DateTimePlayBy < $DateTimeNow) {
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
      <?php 
        if ($shelfSort === 'yes') {
          ?>
          order: [
            [ 1, 'asc'],
            [ 2, 'asc'],
            [ 3, 'asc'],
            [ 4, 'asc'],
            [ 5, 'asc'],
            [ 11, 'asc'],
            [ 10, 'desc'],
          ]
          <?php
        } else {
          ?>
          order: [
            [ 9, 'asc'] // use by date ascending (most recent first)
          ]
          <?php
        }
      ?>
    });
  </script>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
