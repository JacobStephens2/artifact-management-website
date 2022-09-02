<?php

require_once('../../private/initialize.php');
require_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/users/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  // Handle form values sent by new.php

  $player = [];
  $player['id'] = $id ?? '';
  $player['FirstName'] = $_POST['FirstName'] ?? '';
  $player['LastName'] = $_POST['LastName'] ?? '';
  $player['G'] = $_POST['G'] ?? '';
  $player['Age'] = $_POST['Age'] ?? '';

  $result = update_player($player);
  if($result === true) {
    $_SESSION['message'] = 'The player was updated successfully.';
    redirect_to(url_for('/users/show.php?id=' . $id));
  } else {
    $errors = $result;
  }

} else {

  $player = find_player_by_id($id);

}

?>

<?php $page_title = 'Edit player'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main>

  <li><a class="back-link" href="<?php echo url_for('/users/index.php'); ?>">&laquo; Players</a></li>

  <div class="object edit">
    <h1>Edit player</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/users/edit.php?id=' . h(u($id))); ?>" method="post">
      <dl>
        <dt>First Name</dt>
        <dd><input type="text" name="FirstName" value="<?php echo h($player['FirstName']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Last Name</dt>
        <dd><input type="text" name="LastName" value="<?php echo h($player['LastName']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Gender (M, F, or Other)</dt>
        <dd><input type="text" name="G" value="<?php echo h($player['G']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Age</dt>
        <dd><input type="text" name="Age" value="<?php echo h($player['Age']); ?>" /></dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Save player edits" />
      </div>
    </form>

  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
