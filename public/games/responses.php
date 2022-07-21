<?php 
require_once('../../artifacts_private/initialize.php');
require_login();
$use_set = find_responses_by_user_id();
$page_title = 'Artifact Uses';
include(SHARED_PATH . '/staff_header.php');
?>

<main>
  <a class="back-link" href="<?php echo url_for('/games/index.php'); ?>">&laquo; Artifact List</a>
    <h1>Artifact Uses</h1>

    <section class="actions">
      <a class="action" href="<?php echo url_for('/games/response-new.php'); ?>">New Use</a>
      <a class="action" href="<?php echo url_for('/games/playby.php'); ?>">Use Artifacts by Date List</a>
    </section>

  	<table class="list">
  	  <tr>
        <th>Play Date</th>
        <th>Title</th>
        <th>Player</th>
  	  </tr>

      <?php while($use = mysqli_fetch_assoc($use_set)) { ?>
        <tr>
          <td class="date">
            <a class="action" href="<?php echo url_for('/games/response-edit.php?id=' . h(u($use['id']))); ?>">
              <?php echo h($use['PlayDate']); ?>
            </a>
          </td>

    	    <td>
            <?php echo h($use['Title']); ?>
          </td>
    	    
          <td class="playerName">
            <?php echo h($use['FirstName']) . ' ' . h($use['LastName']); ?>
          </td>
    	  </tr>
      <?php } ?>
  	</table>

    <?php mysqli_free_result($use_set); ?>

</main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
