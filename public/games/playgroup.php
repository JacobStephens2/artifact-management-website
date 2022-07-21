<?php require_once('../../artifacts_private/initialize.php'); ?>

<?php
require_login();

  $object_set = find_playgroup_by_user_id();

?>

<?php $page_title = 'objects'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<main>
  <div class="objects listing">
    <h1>Playgroup</h1>

    <div class="actions">
      <li><a class="action" href="<?php echo url_for('/games/playgroup-new.php'); ?>">Add to playgroup</a></li>
      <li><a class="action" href="<?php echo url_for('/games/playgroup-choose.php'); ?>">Choose games for playgroup</a></li>
    </div>

  	<table class="list">
  	  <tr>
        <!-- <th>ID</th> -->
        <th>Name&ensp;</th>
        <th>Playgroup id&ensp;</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($object = mysqli_fetch_assoc($object_set)) { ?>
        <tr>
          <td><?php echo h($object['FirstName']) . ' ' . h($object['LastName']); ?></td>
          <td><?php echo h($object['ID']); ?></td>
          <td><a class="table-action" href="<?php echo url_for('/players/show.php?id=' . h(u($object['playerID']))); ?>">View</a></td>
          <td><a class="table-action" href="<?php echo url_for('/games/playgroup-edit.php?ID=' . h(u($object['ID']))); ?>">Edit</a></td>
          <td><a class="table-action" href="<?php echo url_for('/games/playgroup-delete.php?ID=' . h(u($object['ID']))); ?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

    <?php
      mysqli_free_result($object_set);
    ?>
  </div>

      </main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
