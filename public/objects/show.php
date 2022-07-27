<?php require_once('../../artifacts_private/initialize.php'); ?>

<?php require_login();

// $id = isset($_GET['id']) ? $_GET['id'] : '1';
$id = $_GET['id'] ?? '1'; // PHP > 7.0

$object = find_object_by_id($id);

?>

<?php $page_title = 'Show object'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main>

  <li><a class="back-link" href="<?php echo url_for('/objects/index.php'); ?>">&laquo; Objects</a></li>
  <li><a class="back-link" href="<?php echo url_for('/objects/useby.php'); ?>">&laquo; Use by</a></li>
  <li><a class="back-link" href="<?php echo url_for('/objects/new.php'); ?>">&laquo; Add new object</a></li>
  <li><a class="action" href="<?php echo url_for('/objects/edit.php?id=' . h(u($object['ID']))); ?>">Edit</a></li>

  <div class="object show">

    <h1>Object: <?php echo h($object['ObjectName']); ?></h1>

    <div class="attributes">
      <dl>
        <dt>Object name</dt>
        <dd><?php echo h($object['ObjectName']); ?></dd>
      </dl>
      <dl>
        <dt>Acquisition date</dt>
        <dd><?php echo h($object['Acq']); ?></dd>
      </dl>
      <dl>
        <dt>Kept in collection</dt>
        <dd><?php echo $object['KeptCol'] == '1' ? 'true' : 'false'; ?></dd>
      </dl>
      <dl>
        <dt>Object type</dt>
        <dd><?php echo h($object['ObjectType']); ?></dd>
      </dl>
    </div>

    <hr />

  </div>


  </div>

</main>
