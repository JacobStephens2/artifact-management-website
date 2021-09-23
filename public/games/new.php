<?php

require_once('../../artifacts_private/initialize.php');
require_login();


if(is_post_request()) {

  $object = [];
  $object['Title'] = $_POST['Title'] ?? '';
  $object['Acq'] = $_POST['Acq'] ?? '';
  $object['type'] = $_POST['type'] ?? '';
  $object['KeptCol'] = $_POST['KeptCol'] ?? '';


  $result = insert_game($object);
  if($result === true) {
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'The object was created successfully.';
    redirect_to(url_for('/games/show.php?id=' . $new_id));
  } else {
    $errors = $result;
  }

} else {
  // display the blank form
  $object = [];
  $object["Title"] = '';
  $object["type"] = '';
  $object["Acq"] = '';
  $object["KeptCol"] = '';
}

?>

<?php $page_title = 'Create object'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/games/index.php'); ?>">&laquo; Back to List</a>

  <div class="object new">
    <h1>Create game</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/games/new.php'); ?>" method="post">
      <dl>
        <dt>Title</dt>
        <dd><input type="text" name="Title" value="<?php echo h($object['Title']); ?>" /></dd>
      </dl>
      <dl>
        <dt>type</dt>
        <dd>
          <select name="type">
            <option value="board-game" selected>Board Game</option>
            <option value="role-playing-game">Role Playing Game</option>
            <option value="video-game">Video Game</option>
            <option value="sport">Sport</option>
            <option value="game">Game</option>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Acq</dt>
        <dd><input type="date" name="Acq" value="<?php echo date('Y') . '-' . date('m') . '-' . date('d'); ?>"/></dd>
      </dl>
      <dl>
        <dt>KeptCol</dt>
        <dd>
          <input type="hidden" name="KeptCol" value="0" />
          <input type="checkbox" name="KeptCol" value="1" checked/>
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Create game" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
