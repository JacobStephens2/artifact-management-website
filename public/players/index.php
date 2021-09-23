<?php require_once('../../artifacts_private/initialize.php'); ?>

<?php
require_login();

  $plural_page_name = 'Players';
  $singular_page_name = 'Player';
  $player_set = find_players_by_user_id();
?>

<?php $page_title = 'objects'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <div class="objects listing">
    <h1><?php echo $plural_page_name; ?></h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/players/new.php'); ?>">Add New <?php echo $singular_page_name; ?></a>
    </div>

  	<table class="list">
  	  <tr>
        <!-- <th>ID</th> -->
        <th>Name&ensp;</th>
        <th>Gender&ensp;</th>
  	    <th>Age&ensp;</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($player = mysqli_fetch_assoc($player_set)) { ?>
        <tr>
          <td><?php echo h($player['FirstName']) . ' ' . h($player['LastName']); ?></td>
    	    <td><?php echo h($player['G']); ?></td>
    	    <td><?php echo h($player['Age']); ?></td>
          <td><a class="table-action" href="<?php echo url_for('/players/show.php?id=' . h(u($player['id']))); ?>">View</a></td>
          <td><a class="table-action" href="<?php echo url_for('/players/edit.php?id=' . h(u($player['id']))); ?>">Edit</a></td>
          <td><a class="table-action" href="<?php echo url_for('/players/delete.php?id=' . h(u($player['id']))); ?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

    <?php
      mysqli_free_result($player_set);
    ?>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
