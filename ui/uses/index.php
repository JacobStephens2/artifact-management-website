<?php 
require_once('../../private/initialize.php');
require_login();
$use_set = find_responses_by_user_id();
$page_title = 'Artifact Uses';
include(SHARED_PATH . '/header.php');
?>

<main>
    <h1>Artifact Uses</h1>

  	<table class="list">
  	  <tr id="headerRow">
        <th>Play Date (<?php echo $use_set->num_rows; ?>)</th>
        <th>Title</th>
        <th>Player</th>
  	  </tr>

      <?php while($use = mysqli_fetch_assoc($use_set)) { ?>
        <tr>
          <td class="date">
            <a 
              class="action" 
              href="<?php echo url_for('/uses/edit.php?id=' . h(u($use['responseID']))); ?>"
              >
              <?php echo h($use['PlayDate']); ?>
            </a>
          </td>
          
    	    <td>
            <a 
              class="action" 
              href="<?php echo url_for('/uses/edit.php?id=' . h(u($use['responseID']))); ?>"
              >
              <?php echo h($use['Title']); ?>
            </a>
          </td>
    	    
          <td class="playerName">
            <?php echo h($use['FirstName']) . ' ' . h($use['LastName']); ?>
          </td>
    	  </tr>
      <?php } ?>
  	</table>

    <?php mysqli_free_result($use_set); ?>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
