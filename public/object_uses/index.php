<?php require_once('../../artifacts_private/initialize.php'); ?>

<?php
require_login();

  $use_set = find_all_uses();

?>

<?php $page_title = 'uses'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
      <li><a class="back-link" href="<?php echo url_for('/objects/index.php'); ?>">&laquo; Objects</a></li>
      <li><a class="back-link" href="<?php echo url_for('/objects/useby.php'); ?>">&laquo; Use objects by list</a></li>
  <div class="uses listing">
    <h1>Object Uses</h1>

    <div class="actions">
      <li><a class="action" href="<?php echo url_for('/object_uses/new.php'); ?>">Record New Use</a></li>
    </div>

  	<table class="list">
  	  <tr>
        <!-- <th>ID</th> -->
        <th>UseDate</th>
        <th>ObjectName</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($use = mysqli_fetch_assoc($use_set)) { ?>
        <tr>
          <!-- <td><?php // echo h($use['ID']); ?></td> -->
          <td><?php echo h($use['UseDate']); ?></td>
    	    <td><?php echo h($use['ObjectName']); ?></td>
          <td><a class="action" href="<?php echo url_for('/object_uses/show.php?id=' . h(u($use['ID']))); ?>">View</a></td>
          <td><a class="action" href="<?php echo url_for('/object_uses/edit.php?id=' . h(u($use['ID']))); ?>">Edit</a></td>
          <td><a class="action" href="<?php echo url_for('/object_uses/delete.php?id=' . h(u($use['ID']))); ?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

    <?php
      mysqli_free_result($use_set);
    ?>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
