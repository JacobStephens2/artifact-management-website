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

  <h1>Use Artifacts by Date</h1>

  <a class="hideOnPrint" href="<?php echo url_for('/objects/about-useby.php'); ?>">Learn About Use-by Date Generation</a>
  
  <form action="<?php echo url_for('/artifacts/useby.php'); ?>" method="post">
      <div class="hideOnPrint">
        <label for="type">Artifact Type</label>
        <select name="type" id="type">
          <option value="1" <?php if ($type == 1) { echo 'selected'; } ?>>All types</option>
          <option value="board-game" <?php if ($type == 'board-game') { echo 'selected'; } ?>>Board Game</option>
          <option value="role-playing-game" <?php if ($type == 'role-playing-game') { echo 'selected'; } ?>>Role Playing Game</option>
          <option value="video-game" <?php if ($type == 'video-game') { echo 'selected'; } ?>>Video Game</option>
          <option value="sport" <?php if ($type == 'sport') { echo 'selected'; } ?>>Sport</option>
          <option value="game" <?php if ($type == 'game') { echo 'selected'; } ?>>Game</option>
          <option value="drink" <?php if ($type == 'drink') { echo 'selected'; } ?>>Drink</option>
          <option value="food" <?php if ($type == 'food') { echo 'selected'; } ?>>Food</option>
          <option value="other" <?php if ($type == 'other') { echo 'selected'; } ?>>Other</option>
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

  <table class="list">
    <tr id="headerRow">
      <th>Name (<?php echo $artifact_set->num_rows; ?>)</th>
      <th>C</th>
      <th>U</th>
      <th>O</th>
      <th>Use By</th>
      <th class="hideOnPrint">Recent Use</th>
      <th>Type</th>
    </tr>

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
  </table>

  <?php mysqli_free_result($artifact_set); ?>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
