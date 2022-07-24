<?php 
require_once('../../artifacts_private/initialize.php');
require_login();
$id = $_GET['id'] ?? '1';
$object = find_game_by_id($id);
$page_title = 'Show object';
include(SHARED_PATH . '/staff_header.php');
?>

<main>

  <li><a class="back-link" href="<?php echo url_for('/games/index.php'); ?>">&laquo; To Artifact List</a></li>
  <li><a class="back-link" href="<?php echo url_for('/games/playby.php'); ?>">&laquo; To Use By List</a></li>
  <li><a class="back-link" href="<?php echo url_for('/games/new.php'); ?>">&laquo; Create New Artifact</a></li>
  <li><a class="back-link" href="<?php echo url_for('/games/response-new.php?gameID=' . h(u($object['id']))); ?>">&laquo; Record Use</a></li>
  
  <h1>Title: <?php echo h($object['Title']); ?></h1>
  
  <dl>
    <dt>Acquisition Date</dt>
    <dd><?php echo h($object['Acq']); ?></dd>
  </dl>
  
  <dl>
    <dt>Kept in Collection?</dt>
    <dd><?php echo $object['KeptCol'] == '1' ? 'true' : 'false'; ?></dd>
  </dl>
  
  <dl>
    <dt>Type</dt>
    <dd><?php echo h($object['type']); ?></dd>
  </dl>

  <li><a class="back-link" href="<?php echo url_for('/games/edit.php?id=' . h(u($object['id']))); ?>">Edit</a></li>
  
</main>
