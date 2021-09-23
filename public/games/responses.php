<?php require_once('../../artifacts_private/initialize.php'); ?>

<?php
require_login();

  $use_set = find_responses_by_user_id();

?>

<?php $page_title = 'Game responses'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <a class="back-link" href="<?php echo url_for('/games/index.php'); ?>">&laquo; Games</a>
  <div class="uses listing">
    <h1>Game responses</h1>

      <li><a class="action" href="<?php echo url_for('/games/response-new.php'); ?>">New response</a></li>
      <li><a class="action" href="<?php echo url_for('/games/playby.php'); ?>">Play games by date</a></li>
      <br>

  	<table class="list">
  	  <tr>
        <th>Play date</th>
        <th>Title</th>
        <th>Player</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($use = mysqli_fetch_assoc($use_set)) { ?>
        <tr>
          <td><?php echo h($use['PlayDate']); ?></td>
    	    <td><?php echo h($use['Title']); ?></td>
    	    <td><?php echo h($use['FirstName']) . ' ' . h($use['LastName']); ?></td>
          <td><a class="action" href="<?php echo url_for('/games/response-show.php?id=' . h(u($use['id']))); ?>">View</a></td>
          <td><a class="action" href="<?php echo url_for('/games/response-edit.php?id=' . h(u($use['id']))); ?>">Edit</a></td>
          <td><a class="action" href="<?php echo url_for('/games/response-delete.php?id=' . h(u($use['id']))); ?>">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

    <?php
      mysqli_free_result($use_set);
    ?>
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
