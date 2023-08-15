<?php 
  require_once('../../private/initialize.php');
  require_login();
  $page_title = 'Artifact Uses';
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

  $minimumDate = $_POST['minimumDate'] ?? date('Y-m-d', strtotime('1 year ago'));

  $use_set = find_uses_by_user_id($type, $minimumDate);
?>

<main>
    <h1><?php echo $page_title; ?></h1>

    <form method="POST">
      <label for="artifactType">Artifact type</label>
      <section id="artifactType" style="display: flex; flex-wrap: wrap">
        <?php require_once SHARED_PATH . '/artifact_type_checkboxes.php'; ?>
      </section>

      <label for="minimumDate">Minimum Date</label>
      <input type="date" name="minimumDate" id="minimumDate" value="<?php echo $minimumDate; ?>">

      <button type="submit">Submit</button>
    </form>

  	<table class="list" id="uses" data-page-length='100'>
      <thead>
        <tr id="headerRow">
          <th>Use Date (<?php echo $use_set->num_rows; ?>)</th>
          <th>Title</th>
          <th>C</th>
          <th>SwS</th>
          <th>User Count</th>
          <th>Users</th>
          <th>Type</th>
          <th>Note</th>
        </tr>
      </thead>

      <tbody>
        <?php 

          $group_setting_game_array = array();
          $group_and_setting_array = array();

          while($use = mysqli_fetch_assoc($use_set)) { 
          
          ?>
          <?php $usersResultObject = find_users_by_use_id($use['useID']); ?>
          <tr>
            <td class="date">
              <a 
                class="action" 
                href="<?php echo url_for('/uses/1-n-edit.php?id=' . h(u($use['useID']))); ?>"
                >
                <?php echo h(substr($use['use_date'],0,10)); ?>
              </a>
            </td>
            
            <td>
              <a 
                class="action" 
                href="<?php echo url_for('/artifacts/edit.php?id=' . h(u($use['gameID']))); ?>"
                >
                <?php echo h($use['Title']); ?>
              </a>
            </td>

            <td>
              <?php 
                if (h($use['Candidate']) != '' && h($use['Candidate']) != 0) {
                  echo 'Yes';
                } 
              ?>
            </td>

            <td>
              <?php echo h($use['SwS']); ?>
            </td>

            <td>
              <?php echo $usersResultObject->num_rows; ?>
            </td>

            <td>
              <?php 
                $i = 0;
                $situation = '';
                if ($usersResultObject->num_rows < 10) {
                  $situation .= '0';
                }
                
                $situation .= $usersResultObject->num_rows . ': ';
                
                $usersArray = [];
                foreach ($usersResultObject as $user) {
                  $usersArray[$user['id']] = $user['FirstName'] . ' ' . $user['LastName'];
                }

                // sort by the key ascending
                ksort($usersArray);

                $i = 0;
                foreach ($usersArray as $user) {
                  $i++;
                  $situation .= $user;
                  if ($i != $usersResultObject->num_rows) {
                    $situation .= ', ';
                  }
                }

                if ($use['note'] != 'online') {
                  $situation .= ' at';
                }

                $situation .= ' ' . $use['note'];

                $group_and_setting = $situation;
                if (!in_array($group_and_setting, $group_and_setting_array)) {
                  $group_and_setting_array[] = $group_and_setting;
                }

                $situation .= ' (';
                $situation .= h($use['Title']);

                $group_setting_game = $situation;

                if (!in_array($group_setting_game, $group_setting_game_array)) {
                  $group_setting_game_array[] = $group_setting_game;
                }

                $situation .= ' on ' . h(substr($use['use_date'],0,10));
                $situation .= ')';

                echo $situation;
              ?>
            </td>
                        
            <td class="type">
              <?php echo h($use['type']); ?>
            </td>

            <td>
              <?php echo h($use['note']); ?>
            </td>
            
          </tr>
        <?php } ?>
      </tbody>
  	</table>

    <p>Group, setting, and game combinations: <?php echo count($group_setting_game_array); ?></p>
    <p>Group and setting combinations: <?php echo count($group_and_setting_array); ?></p>

    <?php mysqli_free_result($use_set); ?>

    <script>
      let table = new DataTable('#uses', {
        // options
        order: [
          [ 0, 'desc'], // Most recent first
          [ 5, 'asc'] // User group first
        ]
      });
    </script>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
