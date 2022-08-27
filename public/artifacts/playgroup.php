<?php
require_once('../../artifacts_private/initialize.php');
require_login();
$object_set = find_playgroup_by_user_id();
$page_title = 'User Group';
include(SHARED_PATH . '/header.php');
?>

<main>
  <div class="objects listing">
    <h1><?php echo $page_title; ?></h1>

    <div class="actions">
      <li><a class="action" href="<?php echo url_for('/artifacts/playgroup-new.php'); ?>">Add to User Group</a></li>
      <li><a class="action" href="<?php echo url_for('/artifacts/playgroup-choose.php'); ?>">Choose Games for User Group</a></li>
    </div>

  	<table class="list">
  	  <tr>
        <th>Name (<?php echo $object_set->num_rows; ?>)</th>
        <th>User Group ID&ensp;</th>
  	    <th></th>
  	    <th></th>
        <th></th>
  	  </tr>

      <?php while($object = mysqli_fetch_assoc($object_set)) { ?>
        <tr>
          <td><?php echo h($object['FirstName']) . ' ' . h($object['LastName']); ?></td>
          <td><?php echo h($object['ID']); ?></td>
          <td>
            <a class="table-action" href="<?php echo url_for('/users/show.php?id=' . h(u($object['playerID']))); ?>">
              View
            </a>
          </td>
          <td>
            <a class="table-action" href="<?php echo url_for('/artifacts/playgroup-edit.php?ID=' . h(u($object['ID']))); ?>">
              Edit
            </a>
          </td>
          <td>    
            <a class="table-action" href="<?php echo url_for('/artifacts/playgroup-delete.php?ID=' . h(u($object['ID']))); ?>">
              Delete
            </a>
          </td>
    	  </tr>
      <?php } ?>
  	</table>

    <?php mysqli_free_result($object_set); ?>
  </div>
</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
