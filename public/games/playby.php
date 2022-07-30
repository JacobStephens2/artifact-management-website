<?php require_once('../../artifacts_private/initialize.php'); ?>
<?php require_login(); ?>
<?php $page_title = 'Use By'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<?php
$type = $_POST['type'] ?? '1';
$interval = $_POST['interval'] ?? '180';
$game_set = play_by($type, $interval);
?>

<main>
  <li><a class="back-link" href="<?php echo url_for('/games/responses.php'); ?>">&laquo; Uses</a></li>
  <li><a class="back-link" href="<?php echo url_for('/games/index.php'); ?>">&laquo; Artifacts</a></li>
    
  <h1>Use Artifacts by Date</h1>

  <li><a class="back-link" href="<?php echo url_for('/uses/create.php'); ?>">Record Use</a></li>
  <li><a class="back-link" href="<?php echo url_for('/objects/about-useby.php'); ?>">Learn About Use-by Date Generation</a></li>

  <form action="<?php echo url_for('/games/playby.php'); ?>" method="post">
    <label for="type">Artifact Type</label>
    <select name="type" id="type">
      <option value="1" <?php if ($type == 1) { echo 'selected'; } ?>>All types</option>
      <option value="board-game" <?php if ($type == 'board-game') { echo 'selected'; } ?>>Board Game</option>
      <option value="role-playing-game" <?php if ($type == 'role-playing-game') { echo 'selected'; } ?>>Role Playing Game</option>
      <option value="video-game" <?php if ($type == 'video-game') { echo 'selected'; } ?>>Video Game</option>
      <option value="sport" <?php if ($type == 'sport') { echo 'selected'; } ?>>Sport</option>
      <option value="game" <?php if ($type == 'game') { echo 'selected'; } ?>>Game</option>
    </select>

    <label for="interval">Interval in days from most recent or to upcoming use</label>
    <input type="number" name="interval" id="interval" value="<?php echo $interval ?>">
    
    <input type="submit" value="Submit" />
  </form>

  <table class="list">
    <tr id="headerRow">
      <th class="table-header">Name</th>
      <th class="table-header">Type</th>
      <th class="table-header">Play By</th>
      <th class="table-header">Recent Use</th>
      <th class="table-header">Acquisition</th>
    </tr>

    <?php while($game = mysqli_fetch_assoc($game_set)) { ?>
      <tr>
        <td class="edit">
          <a class="action edit" href="<?php echo url_for('/games/edit.php?id=' . h(u($game['id']))); ?>">
          <?php echo h($game['Title']); ?></a>
          </a>
        </td>
        <td class="edit"><?php echo h($game['type']); ?></td>
        <td class="edit"><?php echo h($game['PlayBy']); ?></td>
        <td class="edit"><?php echo h($game['MaxPlay']); ?></td>
        <td class="edit"><?php echo h($game['Acq']); ?></td>
      </tr>
    <?php } ?>
  </table>

  <?php mysqli_free_result($game_set); ?>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
