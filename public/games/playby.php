<?php 
require_once('../../artifacts_private/initialize.php');
require_login();
$page_title = 'Use By';
include(SHARED_PATH . '/header.php');
$type = $_POST['type'] ?? '1';
$interval = $_POST['interval'] ?? '90';
$game_set = play_by($type, $interval);
?>

<main>
  <div class="hideOnPrint">
    <li><a class="back-link" href="<?php echo url_for('/games/responses.php'); ?>">&laquo; Uses</a></li>
    <li><a class="back-link" href="<?php echo url_for('/games/index.php'); ?>">&laquo; Artifacts</a></li>
  </div>

  <h1>Use Artifacts by Date</h1>

  <div class="hideOnPrint">
    <li><a class="back-link" href="<?php echo url_for('/uses/create.php'); ?>">Record Use</a></li>
    <li><a class="back-link" href="<?php echo url_for('/objects/about-useby.php'); ?>">Learn About Use-by Date Generation</a></li>
  </div>
  
  <form action="<?php echo url_for('/games/playby.php'); ?>" method="post">
      <div class="hideOnPrint">
        <label for="type">Artifact Type</label>
        <select name="type" id="type">
          <option value="1" <?php if ($type == 1) { echo 'selected'; } ?>>All types</option>
          <option value="board-game" <?php if ($type == 'board-game') { echo 'selected'; } ?>>Board Game</option>
          <option value="role-playing-game" <?php if ($type == 'role-playing-game') { echo 'selected'; } ?>>Role Playing Game</option>
          <option value="video-game" <?php if ($type == 'video-game') { echo 'selected'; } ?>>Video Game</option>
          <option value="sport" <?php if ($type == 'sport') { echo 'selected'; } ?>>Sport</option>
          <option value="game" <?php if ($type == 'game') { echo 'selected'; } ?>>Game</option>
        </select>
      </div>

      <div class="displayOnPrint">
        <label for="interval">Interval in days from most recent or to upcoming use</label>
        <input type="number" name="interval" id="interval" value="<?php echo $interval ?>">
      </div>
      
      <input type="submit" value="Submit" class="hideOnPrint"/>
    </form>

  <p>C stands for Candidate</p>

  <table class="list">
    <tr id="headerRow">
      <th class="table-header">Name</th>
      <th class="table-header">Type</th>
      <th class="table-header">Use By</th>
      <th class="table-header">C</th>
      <th class="table-header">Recent Use</th>
      <th class="table-header">Overdue</th>
    </tr>

    <?php while($game = mysqli_fetch_assoc($game_set)) { ?>
      <tr>
        <td class="edit">
          <a class="action edit" href="<?php echo url_for('/games/edit.php?id=' . h(u($game['id']))); ?>">
          <?php echo h($game['Title']); ?></a>
          </a>
        </td>
        <td class="edit type"><?php echo h($game['type']); ?></td>
        <td class="edit date"><?php echo h($game['PlayBy']); ?></td>
        <td class="edit"><?php echo h($game['Candidate']); ?></td>
        <td class="edit date"><?php echo h($game['MaxPlay']); ?></td>
        <td 
            <?php 
                if ($game['PlayBy'] < date('Y-m-d')) {
                  echo 'style="color: red;"';
                }
            ?>
            >
            <?php 
                if ($game['PlayBy'] < date('Y-m-d')) {
                  echo 'Overdue';
                } else {
                  echo 'No';
                }
            ?>
          </td>
      </tr>
    <?php } ?>
  </table>

  <?php mysqli_free_result($game_set); ?>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
