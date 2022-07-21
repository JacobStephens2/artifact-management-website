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

<main>

  <a class="back-link" href="<?php echo url_for('/games/index.php'); ?>">&laquo; Back to List</a>

  <div class="object new">
    <h1>Create Artifact</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/games/new.php'); ?>" method="post">

      <label for="Title">Name</label>
      <input type="text" name="Title" id="Title" value="<?php echo h($object['Title']); ?>" /></dd>
      
      <label for="type">Type</label>
      <select name="type" id="type">
        <option value="board-game" selected>Board Game</option>
        <option value="role-playing-game">Role Playing Game</option>
        <option value="video-game">Video Game</option>
        <option value="sport">Sport</option>
        <option value="game">Game</option>
        <option value="video">Video</option>
      </select>
      
      <label for="Acq">Acquisition Date</label>
      <input type="date" name="Acq" id="Acq" value="<?php echo date('Y') . '-' . date('m') . '-' . date('d'); ?>"/>

      <label for="KeptCol">Kept in Collection (Checked Means Yes)</label>
      <input type="hidden" name="KeptCol" value="0" />
      <input type="checkbox" name="KeptCol" value="1" checked/>

      <div id="operations">
        <input type="submit" value="Create game" />
      </div>
    </form>

  </div>

</main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
