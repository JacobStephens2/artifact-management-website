<?php 
require_once('../../artifacts_private/initialize.php');
require_login();
$kept = $_GET['kept'] ?? '';
$type = $_POST['type'] ?? '1';
$object_set = find_games_by_user_id($kept, $type);
$page_title = 'Artifacts';
include(SHARED_PATH . '/header.php'); 
?>

<main>
  <div class="objects listing">
    <h1>Artifacts</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/artifacts/new.php'); ?>">Create Artifact</a>
      <a class="action" href="<?php echo url_for('/artifacts/playby.php'); ?>">Use Artifacts By Date List</a>
      <a class="action" href="<?php echo url_for('/uses/create.php'); ?>">Record Use</a>
      <a class="action" href="<?php echo url_for('/artifacts/responses.php'); ?>">Uses</a>
    </div>

    <form action="<?php echo url_for('/artifacts/index.php'); ?>" method="post">
      <label for="type">Game type</label>
      <select name="type" id="type">
        <option value="1" <?php if ($type == 1) { echo 'selected'; } ?>>All types</option>
        <option value="board-game" <?php if ($type == 'board-game') { echo 'selected'; } ?>>Board Game</option>
        <option value="role-playing-game" <?php if ($type == 'role-playing-game') { echo 'selected'; } ?>>Role Playing Game</option>
        <option value="video-game" <?php if ($type == 'video-game') { echo 'selected'; } ?>>Video Game</option>
        <option value="sport" <?php if ($type == 'sport') { echo 'selected'; } ?>>Sport</option>
        <option value="game" <?php if ($type == 'game') { echo 'selected'; } ?>>Game</option>
      </select>

      <input type="submit" value="Submit" />
    </form>

    <?php
      if ($kept == 1) {
        echo "<span>Showing Only Artifacts Kept</span>";
        echo '
          <a href="' . url_for("/artifacts/index.php") . '">
            (Show All Artifacts)
          </a>';
      } else {
        echo "<span>Showing All Artifacts</span>";
        echo '
          <a href="' . url_for("/artifacts/index.php?kept=1") . '">
            (Show Only Artifacts Kept)
          </a>';
      }
   ?>

    <p>C stands for Candidate</p>

  	<table class="list">
  	  <tr id="headerRow">
        <th>Acquisition</th>
        <th>Type</th>
        <th>Kept</th>
        <th>Name (<?php echo $object_set->num_rows; ?>)</th>
        <th>C</th>
        <th>Recent Use</th>
        <th>Use By</th>
        <th>Overdue</th>
  	  </tr>

      <?php while($object = mysqli_fetch_assoc($object_set)) { ?>
        <tr>
          <td><?php echo h($object['Acq']); ?></td>
    	    <td><?php echo h($object['type']); ?></td>
          <td><?php echo $object['KeptCol'] == 1 ? 'true' : 'false'; ?></td>
          <td>
            <a class="table-action" href="<?php echo url_for('/artifacts/edit.php?id=' . h(u($object['id']))); ?>">  
              <?php echo h($object['Title']); ?>
            </a>
          </td>
          <td><?php echo h($object['Candidate']); ?></td>
          <td class="date"><?php echo h($object['MaxPlay']); ?></td>
          <td class="date">
            <?php echo h($object['PlayBy']); ?>
          </td>
          <td 
            <?php 
                if ($object['PlayBy'] < date('Y-m-d')) {
                  echo 'style="color: red;"';
                }
            ?>
            >
            <?php 
                if ($object['PlayBy'] < date('Y-m-d')) {
                  echo 'Overdue';
                } else {
                  echo 'No';
                }
            ?>
          </td>
    	  </tr>
      <?php } ?>
  	</table>

    <?php mysqli_free_result($object_set); ?>
  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>