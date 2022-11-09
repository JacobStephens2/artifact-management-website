<?php 
require_once('../../private/initialize.php');
require_login();
$player_set = find_players_by_user_id();
$page_title = 'Users';
include(SHARED_PATH . '/header.php');
?>

<main>
  <div class="objects listing">
    <h1>Users</h1>

  	<table class="list">
  	  <tr id="headerRow">
        <th>Name (<?php echo $player_set->num_rows; ?>)</th>
        <th>Gender</th>
  	    <th>Age</th>
        <th></th>
  	  </tr>

      <?php while($player = mysqli_fetch_assoc($player_set)) { ?>
        <tr>
          <td>
            <a class="table-action" href="<?php echo url_for('/users/edit.php?id=' . h(u($player['id']))); ?>">
              <?php echo h($player['FirstName']) . ' ' . h($player['LastName']); ?>
            </a>
          </td>
    	    <td><?php echo h($player['G']); ?></td>
    	    <td><?php echo h($player['Age']); ?></td>
          <td><a class="table-action" href="<?php echo url_for('/users/delete.php?id=' . h(u($player['id']))); ?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

    <?php
      mysqli_free_result($player_set);
    ?>
  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
