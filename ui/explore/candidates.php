<?php // initialize page

  require_once('../../private/initialize.php');

  require_login();

  $sql = "SELECT * 
    FROM games
    WHERE Candidate IS NOT NULL
    AND Candidate != '0'
    AND Candidate != ''
    AND user_id = " . $_SESSION['user_id'] . "
  ";

  if (isset($_POST['showOnline'])) {

    switch($_POST['showOnline']) {
      case 'showOnlyOnline':
        $sql .= " AND Candidate LIKE '%online%' ";
        break;
      case 'hideOnline':
        $sql .= " AND Candidate NOT LIKE '%online%' ";
        break;
    }

  }
  
  if (isset($_POST['removeUserByName']) && $_POST['removeUserByName'] != '') {
    $sql .= " AND Candidate NOT LIKE '%" . $_POST['removeUserByName'] . "%' ";
  }
  
  if (isset($_POST['removeUserByNameTwo']) && $_POST['removeUserByNameTwo'] != '') {
    $sql .= " AND Candidate NOT LIKE '%" . $_POST['removeUserByNameTwo'] . "%' ";
  }

  $sql .= " ORDER BY type ASC,
    Candidate ASC
  ";

  $resultObject = mysqli_query($db, $sql);

  $page_title = $resultObject->num_rows . " " . 'Candidates';

  include(SHARED_PATH . '/header.php');
  include(SHARED_PATH . '/dataTable.html'); 

?>

<main>

  <style>
    input[type="text"] {
      width: 25rem;
    }
  </style>

  <h1>
    <?php echo $page_title; if ($_SERVER['REQUEST_METHOD'] == 'POST') { echo ' Match Search Results'; } ?>
  </h1>

  <form action="candidates.php" method="POST">

    <section style="display: flex; gap: 1.2rem">
      <div>      
        <label for="showAll" style="display: inline">Show All</label>
        <input type="radio" name="showOnline" id="showAll" value="showAll"
          <?php if (isset($_POST['showOnline']) && $_POST['showOnline'] == 'showAll') { echo ' checked '; } ?>
        >
      </div>

      <div>      
        <label for="hideOnline" style="display: inline">Hide Online</label>
        <input type="radio" name="showOnline" id="hideOnline" value="hideOnline"
          <?php if (isset($_POST['showOnline']) && $_POST['showOnline'] == 'hideOnline') { echo ' checked '; } ?>
        >
      </div>
      
      <div>
        <label for="showOnlyOnline" style="display: inline">Show Only Online</label>
        <input type="radio" name="showOnline" id="showOnlyOnline" value="showOnlyOnline"
        <?php if (isset($_POST['showOnline']) && $_POST['showOnline'] == 'showOnlyOnline') { echo ' checked '; } ?>
        >
      </div>
    </section>

    
    <section style="display: flex; gap: 1.3rem">
      <div style="margin-top: 0.6rem">
        <label for="removeUserByName" style="display: inline">Remove User By Name</label>
        <input type="text" name="removeUserByName" id="removeUserByName" style="display: inline"
          value="<?php if (isset($_POST['removeUserByName'])) { echo $_POST['removeUserByName']; } ?>"
        >
      </div>
      
      <div style="margin-top: 0.6rem">
        <label for="removeUserByNameTwo" style="display: inline">Remove Second User By Name</label>
        <input type="text" name="removeUserByNameTwo" id="removeUserByNameTwo" style="display: inline"
          value="<?php if (isset($_POST['removeUserByNameTwo'])) { echo $_POST['removeUserByNameTwo']; } ?>"
        >
      </div>
    </section>

    <input type="submit" value="Submit">
  </form>

  <table id="candidates" data-page-length='100' class="list">

    <thead style="position: sticky; top: 0;">
      <tr>
        <th>Type</th>
        <th>Users</th>
        <th>Group and Setting</th>
        <th>Group Date</th>
        <th>Artifact (<?php echo $resultObject->num_rows; ?>)</th>
        <th>Recent Use</th>
        <th>SwS</th>
        <th>MnP</th>
        <th>MxP</th>
        <th>AvgT</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($resultObject as $row) { 
        // find most recent use
          $artifact_id = $row['id'];

          $query = "SELECT 
              id,
              MAX(use_date) AS most_recent_use_date
            FROM
              uses
            WHERE
              artifact_id = '$artifact_id' 
              AND user_id = " . $_SESSION['user_id'] . "
          ";

          $mostRecentUseDateArray = singleRowQuery($query);

          $oneToManyUse = true;

          if ($mostRecentUseDateArray['most_recent_use_date'] == NULL) {

            $oneToManyUse = false;

            $query = "SELECT 
                id,
                MAX(PlayDate) AS most_recent_use_date
              FROM
                responses
              WHERE
                Title = '$artifact_id' 
                AND user_id = " . $_SESSION['user_id'] . "
            ";

            $mostRecentUseDateArray = singleRowQuery($query);

          }

          $mostRecentUseDate = $mostRecentUseDateArray['most_recent_use_date'];
        //
        ?>
        <tr>
          <td>
            <?php echo h($row['type']); ?>
          </td>

          <td>
            <?php echo substr(h($row['Candidate']),0,3); ?>
          </td>
          
          <td>
            <?php echo substr(h($row['Candidate']),3); ?>
          </td>
          
          <td class="date">
            <?php echo substr(h($row['CandidateGroupDate']), 0, 10); ?>
          </td>
          
          <td>
            <a href="/artifacts/edit.php?id=<?php echo $row['id']; ?>">
              <?php echo $row['Title']; ?>
            </a>
          </td>

          <td class="mostRecentUse date"
            
            >
            <a
              <?php
                $mostRecentUseTime = strtotime($mostRecentUseDate);
                $oneYearAgoTime = strtotime('now - 1 year');
                if ($mostRecentUseTime < $oneYearAgoTime) {
                  echo ' style="color: red;" ';
                }

                if ($oneToManyUse === true) {
                  ?>
                  href="/uses/1-n-edit.php?id=<?php echo $mostRecentUseDateArray['id']; ?>"
                  <?php
                } elseif ($oneToManyUse === false) {
                  ?>
                  href="/uses/edit.php?id=<?php echo $mostRecentUseDateArray['id']; ?>"
                  <?php
                }
              ?>
              >
              <?php echo h(substr($mostRecentUseDate, 0, 10)) ?>
            </a>
          </td>

          <td>
            <?php echo h($row['SS']); ?>
          </td>
          <td>
            <?php echo h($row['MnP']); ?>
          </td>
          <td>
            <?php echo h($row['MxP']); ?>
          </td>
          
          <td>
            <?php 
              echo h(($row['MnT'] + $row['MxT']) / 2); 
            ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>

  </table>

  <label for="typeOptions">Type Options</label>
  <select id="typeOptions">
    <?php 
      $type = '';
      include(SHARED_PATH . '/artifact_type_options.php'); 
    ?>
  </select>

  <script>
    let table = new DataTable('#candidates', {
      // options
      order: [
        [ 1, 'asc'], // Users
        [ 5, 'desc'], // Recent Use
        [ 6, 'asc'], // SwS
        [ 9, 'asc'], // AvgT
        [ 7, 'asc'], // MnP
      ] 
    });
  </script>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>