<?php 
require_once('../../artifacts_private/initialize.php');
require_login();
$use_set = find_responses_by_user_id();
$page_title = 'Game responses';
include(SHARED_PATH . '/staff_header.php');
?>

<div id="content">
  <a class="back-link" href="<?php echo url_for('/games/index.php'); ?>">&laquo; Games List</a>
  <div class="uses listing">
    <h1>Game Responses</h1>

    <li>
      <a class="action" href="<?php echo url_for('/games/response-new.php'); ?>">New Response</a>
    </li>
    <li>
      <a class="action" href="<?php echo url_for('/games/playby.php'); ?>">Play Games by Date List</a>
    </li>

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
  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
