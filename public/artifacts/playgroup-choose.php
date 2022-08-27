<?php
require_once('../../artifacts_private/initialize.php');
require_login();
$page_title = 'Choose for group';
include(SHARED_PATH . '/header.php');
if(is_post_request()) {
  $_SESSION['range'] = $_POST['range'] ?? 'false';
  $_SESSION['type'] = $_POST['type'] ?? '1';
}
$range = $_SESSION['range'] ?? 'false';
$type = $_SESSION['type'] ?? '1';
$game_set = choose_games_for_group($range, $type);
$usergroup = find_playgroup_by_user_id();
?>

<main>
    <li><a class="back-link" href="<?php echo url_for('/artifacts/playgroup.php'); ?>">&laquo; User group</a></li>
  <div class="objects listing">
    <h1>Choose Artifacts for Group of <?php echo $usergroup->num_rows; ?> Users</h1>
    <p>
      The dates represent the most recent instance of the type of response indicated by the column header. SS = sweet spot, Mnp = minimum player count, Mxp = maximum player count.
    </p>

    <!-- Parameters form -->
    <form action="<?php echo url_for('/artifacts/playgroup-choose.php'); ?>" method="post">

        <label for="range">Show only artifacts matching count of user group (Unchecked shows all uses of each user)</label>
        <input type="hidden" name="range" value="false" />
        <input type="checkbox" id="range" name="range" value="true" <?php if($range == 'true') { echo " checked"; } ?> />

        <label for="type">Artifact type</label>
        <select id="type" name="type">
          <option value="1" <?php if ($_SESSION['type'] == 1) { echo 'selected'; } ?>>All types</option>
          <option value="board-game" <?php if ($_SESSION['type'] == 'board-game') { echo 'selected'; } ?>>Board Game</option>
          <option value="role-playing-game" <?php if ($_SESSION['type'] == 'role-playing-game') { echo 'selected'; } ?>>Role Playing Game</option>
          <option value="video-game" <?php if ($_SESSION['type'] == 'video-game') { echo 'selected'; } ?>>Video Game</option>
          <option value="sport" <?php if ($_SESSION['type'] == 'sport') { echo 'selected'; } ?>>Sport</option>
          <option value="game" <?php if ($_SESSION['type'] == 'game') { echo 'selected'; } ?>>Game</option>
        </select>

        <input type="submit" value="Submit" />
    </form>

  	<table class="list">
  	  <tr class="header-row">
        <th class="table-header">Artifact</th>
  	    <th class="table-header">Player</th>
        <th class="table-header">SS</th>
        <th class="table-header">MnP</th>
        <th class="table-header">MxP</th>
        <th class="table-header">MxT</th>
  	    <th class="table-header">Play</th>
  	    <th class="table-header">Aversion</th>
  	    <th class="table-header">Type</th>
  	  </tr>

      <?php while($game = mysqli_fetch_assoc($game_set)) { ?>
        <tr>
          <td class="edit">
            <a class="table-action" href="<?php echo url_for('/artifacts/edit.php?id=' . h(u($game['id']))); ?>">
              <?php echo h($game['title']); ?>
            </a>
          </td>
    	    <td class="edit"><?php echo h($game['FirstName']) . ' ' . h($game['LastName']); ?></td>
    	    <td class="edit"><?php echo ltrim(h($game['ss']), '0'); ?></td>
          <td class="edit"><?php echo h($game['MnP']); ?></td>
          <td class="edit"><?php echo h($game['MxP']); ?></td>
          <td class="edit"><?php echo h($game['MxT']); ?></td>
          <td class="edit">
            <a class="table-action" href="<?php echo url_for('/artifacts/response-edit.php?id=' . h(u($game['ResponseID']))); ?>">
              <?php echo h($game['MaxOfPlayDate']); ?>
            </a>
          </td>
          <td class="edit"><?php echo h($game['MaxOfAversionDate']); ?></td>
          <td class="edit"><?php echo h($game['type']); ?></td>
    	  </tr>
      <?php } ?>
  	</table>

    <?php mysqli_free_result($game_set); ?>
  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
