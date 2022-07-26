<?php require_once('../../artifacts_private/initialize.php'); ?>

<?php require_login();

$id = $_GET['id'] ?? '1'; // PHP > 7.0

$player = find_player_by_id($id);

?>

<?php $page_title = 'Show player'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<main>

  <li><a class="back-link" href="<?php echo url_for('/players/index.php'); ?>">&laquo; Players</a></li>

  <li><a class="back-link" href="<?php echo url_for('/games/playgroup.php'); ?>">&laquo; Playgroup</a></li>

  <li><a class="back-link" href="<?php echo url_for('/players/new.php'); ?>">&laquo; Create New User</a></li>

  <li><a class="back-link" href="<?php echo url_for('/games/response-new.php'); ?>">&laquo; Record Use</a></li>

  <li><a class="action" href="<?php echo url_for('/players/edit.php?id=' . h(u($player['id']))); ?>">Edit</a></li>

  <div class="object show">

    <h1>Name: <?php echo h($player['FirstName']) . ' ' . h($player['LastName']); ?></h1>

    <div class="attributes">
      <dl>
        <dt>Gender</dt>
        <dd><?php echo h($player['G']); ?></dd>
      </dl>
      <dl>
        <dt>Age</dt>
        <dd><?php echo h($player['Age']); ?></dd>
      </dl>
    </div>

    <hr />

  </div>


  </div>

</main>
