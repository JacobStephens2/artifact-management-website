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
      include(SHARED_PATH . '/artifact_type_array.php'); 
      global $typesArray;
      $type = $typesArray;
    }
  }

  $_SESSION['type'] = $type;
  $sweetSpot = $_POST['sweetSpot'] ?? '';
  $minimumAge = $_POST['minimumAge'] ?? 0;
  $shelfSort = $_POST['shelfSort'] ?? 'no';
  $typeArray = $_SESSION['type'] ?? [];
  $interval = $_POST['interval'] ?? DEFAULT_USE_INTERVAL;
  $artifact_set = use_by($type, $interval, $sweetSpot, $minimumAge, $shelfSort);


?>

<main>

  <h1>Use Artifacts by Date</h1>

  <a class="hideOnPrint" href="<?php echo url_for('/objects/about-useby.php'); ?>">Learn About Use-by Date Generation</a>
  
  <div id="intro">
    <form action="<?php echo url_for('/artifacts/useby.php'); ?>" method="post">
      <div class="hideOnPrint">

        <label for="artifactType">Artifact type</label>
        <section id="artifactType" style="display: flex; flex-wrap: wrap">
          <?php require_once SHARED_PATH . '/artifact_type_checkboxes.php'; ?>
        </section>

        <label for="sweetSpot">Sweet Spot</label>
        <input type="number" name="sweetSpot" id="sweetSpot" value="<?php echo $sweetSpot; ?>">

        <label for="minimumAge">Minimum Age</label>
        <input type="number" name="minimumAge" id="minimumAge" value="<?php echo $minimumAge; ?>">
       
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
        <input type="number" step="0.1" name="interval" id="interval" value="<?php echo $interval ?>">
      </div>
      
      <input type="submit" value="Submit" class="hideOnPrint"/>
    </form>

    <section id="legend">
      <p>U stands for used at recommended user count or used fully through at non-recommended count</p>
      <p>O stands for Overdue</p>
    </section>
  </div>

  <table id="useBy" class="list" data-page-length='100'>
    <thead>
      <tr id="headerRow">
        <th>Type</th>
        <th>Name (<?php echo $artifact_set->num_rows; ?>)</th>
        <th>SwS</th>
        <th>AvgT</th>
        <th>Age</th>
        <th>SwS's</th>
        <th>MnP</th>
        <th>MxP</th>
        <th>C</th>
        <th>O</th>
        <th>Use By</th>
        <th class="hideOnPrint">Recent Use</th>
      </tr>
    </thead>

    <tbody>
      <?php while($artifact = mysqli_fetch_assoc($artifact_set)) { 
        ?>
        <tr>
          <td class="type"><?php echo h($artifact['type']); ?></td>

          <td class="name artifact edit">
            <a class="action edit" href="<?php echo url_for('/artifacts/edit.php?id=' . h(u($artifact['id']))); ?>">
            <?php echo h($artifact['Title']); ?></a>
            </a>
          </td>

          <td class="SwS">
            <?php 
              // find the first number without leading zeros
              preg_match(
                '/([1-9][0-9])|[1-9]/', 
                $artifact['ss'],
                $match
              );
              echo h($match[0]); 
            ?>
          </td>
          
          <td class="AvgT"><?php echo (h($artifact['mnt']) + h($artifact['mxt'])) / 2; ?></td>
          <td class="Age"><?php echo h($artifact['age']); ?></td>
          <td class="SwSs"><?php echo h($artifact['ss']); ?></td>
          <td class="MnP" ><?php echo h($artifact['mnp']); ?></td>
          <td class="MxP"><?php echo h($artifact['mxp']); ?></td>
          
          <td class="candidate">
            <?php 
            if ( strlen($artifact['Candidate']) > 0 ) {
              echo 'Yes';
            }
            ?>
          </td>

          <td class="overdue"
            <?php 
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
                date_default_timezone_set('America/New_York');
                $DateTimeNow = new DateTime(date('Y-m-d')); 
                $DateTimeMostRecentUse = new DateTime(substr($artifact['MostRecentUseOrResponse'],0,10)); 
                $DateTimeAcquisition = new DateTime(substr($artifact['Acq'],0,10)); 
                $intervalInHours = $interval * 24;

                if ($DateTimeMostRecentUse < $DateTimeAcquisition || $artifact['MostRecentUseOrResponse'] === NULL) {
                  $DateInterval = DateInterval::createFromDateString("$intervalInHours hour");
                  $useByDate = date_add($DateTimeAcquisition, $DateInterval);
                } else {
                  $doubledInterval = $intervalInHours * 2;
                  $DateInterval = DateInterval::createFromDateString("$doubledInterval hour");
                  $useByDate = date_add($DateTimeMostRecentUse, $DateInterval);
                }

                if ($useByDate < $DateTimeNow) {
                  echo 'style="color: red;"';
                }
            ?>
            >
            <?php 
                if ($useByDate < $DateTimeNow) {
                  echo 'Yes';
                } else {
                  echo 'No';
                }
              ?>
          </td>
          
          <td class="useByDate date"><?php print_r($useByDate->format('Y-m-d')); ?></td>

          <td class="mostRecentUse date hideOnPrint">
            <?php echo h(substr($artifact['MostRecentUseOrResponse'],0,10)); ?>
          </td>

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
            [ 0, 'asc'], // Type
            [ 2, 'asc'], // SwS
            [ 3, 'asc'],  // AvgT
            [ 4, 'asc'], // Age
            [ 5, 'asc'], // SwS's
            [ 6, 'asc'], // MnP
            [ 7, 'asc'], // MxP
            [ 11, 'desc'], // recent use
            [ 8, 'desc'], // C
          ]
          <?php
        } else { 
          ?>
          order: [
            [ 10, 'asc'],  // use by date
            [ 3, 'asc'],  // AvgT
            [ 4, 'asc'],  // Age
          ]
          <?php
        }
      ?>
    });

    document.addEventListener('keypress', function(event) {
      if (event.key === 'Enter') {
        event.preventDefault();
        document.querySelector('form').submit();
      }
    })
  </script>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
