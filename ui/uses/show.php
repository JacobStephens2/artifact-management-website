<?php require_once('../../private/initialize.php'); ?>

<?php require_login();

$id = $_GET['id'] ?? '1'; // PHP > 7.0

$response = find_response_by_id($id);

?>

<?php $page_title = 'Show use'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main>

  <li><a class="action" href="<?php echo url_for('/uses/edit.php?id=' . h(u($response['id']))); ?>">Edit</a></li>

  <div class="use show">

    <div class="attributes">
      <dl>
        <dt>Game: <?php echo h($response['Title']); ?></dt>
      </dl>
      <dl>
        <dt>Date of play: <?php echo h($response['PlayDate']); ?></dt>
      </dl>
      <!-- GET variable approach to passing player id from new page to show -->
      <a href="/uses/edit.php?id=<?php echo $_REQUEST['id']; ?>">
        View user of this response
      </a>
    </div>
    <br />
    <hr />

  </div>


  </div>

</main>
