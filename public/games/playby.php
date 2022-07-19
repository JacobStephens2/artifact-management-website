<?php require_once('../../artifacts_private/initialize.php'); ?>
<?php require_login(); ?>
<?php $page_title = 'Play By'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<?php
$type = $_POST['type'] ?? '1';
$interval = $_POST['interval'] ?? '180';
$game_set = play_by($type, $interval);
?>

<div id="content">
    <li><a class="back-link" href="<?php echo url_for('/games/responses.php'); ?>">&laquo; To responses list</a></li>
    <li><a class="back-link" href="<?php echo url_for('/games/index.php'); ?>">&laquo; To games list</a></li>
  <div class="objects listing">
    <h1>Play games by date</h1>
    <li><a class="back-link" href="<?php echo url_for('/games/response-new.php'); ?>">Record response</a></li>
    <li><a class="back-link" href="<?php echo url_for('/objects/about-useby.php'); ?>">Learn about play-by date generation</a></li>
    <br>
    <form action="<?php echo url_for('/games/playby.php'); ?>" method="post">
      <dl>
        <dt>Game type</dt>
          <select name="type">
            <option value="1" <?php if ($type == 1) { echo 'selected'; } ?>>All types</option>
            <option value="board-game" <?php if ($type == 'board-game') { echo 'selected'; } ?>>Board Game</option>
            <option value="role-playing-game" <?php if ($type == 'role-playing-game') { echo 'selected'; } ?>>Role Playing Game</option>
            <option value="video-game" <?php if ($type == 'video-game') { echo 'selected'; } ?>>Video Game</option>
            <option value="sport" <?php if ($type == 'sport') { echo 'selected'; } ?>>Sport</option>
            <option value="game" <?php if ($type == 'game') { echo 'selected'; } ?>>Game</option>
          </select>
          <dt>Interval from latest or to soonest play (Default = 180)</dt>
          <input type="number" name="interval" value="<?php echo $interval ?>">
      </dl>
      <div id="operations">
        <input type="submit" value="Submit" />
      </div>
    </form>
  	<table class="list">
  	  <tr>
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

    <?php
      mysqli_free_result($game_set);
    ?>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
