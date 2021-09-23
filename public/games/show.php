<?php require_once('../../artifacts_private/initialize.php'); ?>

<?php require_login();

// $id = isset($_GET['id']) ? $_GET['id'] : '1';
$id = $_GET['id'] ?? '1'; // PHP > 7.0

$object = find_game_by_id($id);

?>

<?php $page_title = 'Show object'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <li><a class="back-link" href="<?php echo url_for('/games/index.php'); ?>">&laquo; To game list</a></li>
  <li><a class="back-link" href="<?php echo url_for('/games/playby.php'); ?>">&laquo; To play by list</a></li>
  <li><a class="action" href="<?php echo url_for('/games/edit.php?id=' . h(u($object['id']))); ?>">Edit</a></li>

  <div class="object show">

    <h1>Title: <?php echo h($object['Title']); ?></h1>

    <div class="attributes">
      <dl>
        <dt>Acq</dt>
        <dd><?php echo h($object['Acq']); ?></dd>
      </dl>
      <dl>
        <dt>KeptCol</dt>
        <dd><?php echo $object['KeptCol'] == '1' ? 'true' : 'false'; ?></dd>
      </dl>
      <dl>
        <dt>type</dt>
        <dd><?php echo h($object['type']); ?></dd>
      </dl>
    </div>

    <hr />

  </div>


  </div>

</div>
