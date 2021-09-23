<?php require_once('../../artifacts_private/initialize.php'); ?>

<?php
require_login();

  $kept = $_GET['kept'] ?? '';
  $type = $_POST['type'] ?? '1';
  $object_set = find_games_by_user_id($kept, $type);

?>

<?php $page_title = 'Games'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <div class="objects listing">
    <h1>Games</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/games/new.php'); ?>">Create New Game</a>
    </div>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/games/playby.php'); ?>">Play games by date</a>
    </div>

    <form action="<?php echo url_for('/games/index.php'); ?>" method="post">
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
      </dl>
      <div id="operations">
        <input type="submit" value="Submit" />
      </div>
    </form>


    <?php
      if ($kept == 1) {
        echo '<a href="' . url_for("/games/index.php") . '"><button>Show all games</button></a>';
      } else {
        echo '<a href="' . url_for("/games/index.php?kept=1") . '"><button>Show only games kept</button></a>';
      }
   ?>

  	<table class="list">
  	  <tr>
        <!-- <th>ID</th> -->
        <th>Name&ensp;</th>
        <th>Kept&ensp;</th>
  	    <th>Acquisition&ensp;</th>
        <th>Type&ensp;</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($object = mysqli_fetch_assoc($object_set)) { ?>
        <tr>
          <td><?php echo h($object['Title']); ?></td>
          <td><?php echo $object['KeptCol'] == 1 ? 'true' : 'false'; ?></td>
    	    <td><?php echo h($object['Acq']); ?></td>
    	    <td><?php echo h($object['type']); ?></td>
          <td><a class="table-action" href="<?php echo url_for('/games/show.php?id=' . h(u($object['id']))); ?>">View</a></td>
          <td><a class="table-action" href="<?php echo url_for('/games/edit.php?id=' . h(u($object['id']))); ?>">Edit</a></td>
          <td><a class="table-action" href="<?php echo url_for('/games/delete.php?id=' . h(u($object['id']))); ?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

    <?php
      mysqli_free_result($object_set);
    ?>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
