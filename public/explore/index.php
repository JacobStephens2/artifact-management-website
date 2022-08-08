<?php 

require_once('../../artifacts_private/initialize.php');

require_login();

$kept = $_POST['kept'] ?? '';
$type = $_POST['type'] ?? '1';
$allGames = $_POST['allGames'] ?? '';
$favCt = $_POST['favCt'] ?? '';
$object_set = find_games_by_characteristic($kept, $type, $allGames, $favCt);

$page_title = 'Explore games';

include(SHARED_PATH . '/header.php');

?>

<main>
  <div class="objects listing">
    <h1>Games</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/artifacts/new.php'); ?>">Create New Game</a>
      <a class="action" href="<?php echo url_for('/artifacts/playby.php'); ?>">Play games by date</a>
    </div>

    <form action="<?php echo url_for('/explore/index.php'); ?>" method="post">
      <dl>
        <dt>Game type</dt>
          <select name="type">
            <option value="1" <?php if ($type == '1') { echo 'selected'; } ?>>All types</option>
            <option value="board-game" <?php if ($type == 'board-game') { echo 'selected'; } ?>>Board Game</option>
            <option value="role-playing-game" <?php if ($type == 'role-playing-game') { echo 'selected'; } ?>>Role Playing Game</option>
            <option value="video-game" <?php if ($type == 'video-game') { echo 'selected'; } ?>>Video Game</option>
            <option value="sport" <?php if ($type == 'sport') { echo 'selected'; } ?>>Sport</option>
            <option value="game" <?php if ($type == 'game') { echo 'selected'; } ?>>Game</option>
          </select>
        <dt>Include games from Jacob
          <input type="hidden" name="allGames" value="1" />
          <input type="checkbox" name="allGames" value="true"<?php if($allGames == 'true') { echo " checked"; } ?> />
        </dt>
        <dt>Show only kept games
          <input type="hidden" name="kept" value="" />
          <input type="checkbox" name="kept" value="true"<?php if($kept == 'true') { echo " checked"; } ?> />
        </dt>
        <dt>Order by Fav Ct
          <input type="hidden" name="favCt" value="" />
          <input type="checkbox" name="favCt" value="true"<?php if($favCt == 'true') { echo " checked"; } ?> />
          (default order = sweet spot > max time > min time > age > fav ct > bgg rating)
        </dt>
      </dl>
      <div id="operations">
        <input type="submit" value="Submit" />
      </div>
    </form>

  	<table class="list">
  	  <tr>
        <th>Name&ensp;</th>
        <th>Kept&ensp;</th>
        <th>Type&ensp;</th>
        <th>Min players&ensp;</th>
        <th>Max players&ensp;</th>
        <th>Sweet spot&ensp;</th>
        <th>Year&ensp;</th>
        <th>Weight&ensp;</th>
        <th>Fav Ct&ensp;</th>
        <th>Age&ensp;</th>
        <th>BGG Rat&ensp;</th>
  	  </tr>

      <?php while($object = mysqli_fetch_assoc($object_set)) { ?>
        <tr>
          <td><?php echo h($object['Title']); ?></td>
          <td><?php echo $object['KeptCol'] == 1 ? 'true' : 'false'; ?></td>
    	    <td><?php echo h($object['type']); ?></td>
    	    <td><?php echo h($object['mnp']); ?></td>
    	    <td><?php echo h($object['mxp']); ?></td>
    	    <td><?php echo h($object['ss']); ?></td>
    	    <td><?php echo h($object['yr']); ?></td>
    	    <td><?php echo h($object['wt']); ?></td>
    	    <td><?php echo h($object['favct']); ?></td>
    	    <td><?php echo h($object['age']); ?></td>
    	    <td><?php echo h($object['bgg_rat']); ?></td>
    	  </tr>
      <?php } ?>
  	</table>

    <?php mysqli_free_result($object_set); ?>
  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>