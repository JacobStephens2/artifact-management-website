<?php
require_once('../../artifacts_private/initialize.php');
require_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/artifacts/responses.php'));
}
$id = $_GET['id'];

if(is_post_request()) {
  // handle post requests sent by this page
  $response = [];
  $response['id'] = $id ?? '';
  $response['Title'] = $_POST['Title'] ?? '';
  $response['PlayDate'] = $_POST['PlayDate'] ?? '';
  $response['Player'] = $_POST['Player'] ?? '';

  $result = update_response($response);
  if($result === true) {
    $_SESSION['message'] = 'The object was updated successfully.';
    redirect_to(url_for('/artifacts/response-show.php?id=' . $id));
  } else {
    $errors = $result;
  }
} else {
  $response = find_response_by_id($id);
}

$page_title = 'Edit Aversion';
include(SHARED_PATH . '/header.php');

?>

<main>

  <a class="back-link" href="<?php echo url_for('/artifacts/responses.php'); ?>">&laquo; Back to List</a>

  <div class="object edit">
    <h1><?php echo $page_title; ?></h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/artifacts/response-edit.php?id=' . h(u($id))); ?>" method="post">
      <dl>
        <dt>Artifact</dt>
        <dd>
          <select name="Title">
          <?php
            $type_set = list_games();
            while($type = mysqli_fetch_assoc($type_set)) {
              echo "<option value=\"" . h($type['id']) . "\"";
              if($response["responsetitle"] == $type['id']) {
                echo " selected";
              }
              echo ">" . h($type['Title']) . "</option>";
            }
            mysqli_free_result($type_set);
          ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>User</dt>
        <dd>
          <select name="Player">
            <option value='Invalid'>Choose a User</option>
          <?php
            $player_set = list_players();
            while($player = mysqli_fetch_assoc($player_set)) {
              echo "<option value=\"" . h($player['id']) . "\"";
              if($response["Player"] == $player['id']) {
                echo " selected";
              }
              echo ">" . h($player['FirstName']) . ' ' . h($player['LastName']) . "</option>";
            }
            mysqli_free_result($player_set);
          ?>
          </select>
        </dd>
      </dl>
      
      <dl>
        <dt>Aversion Date</dt>
        <dd><input type="date" name="AversionDate" value="<?php echo h($response['AversionDate']); ?>" /></dd>
      </dl>
      <dl>
        <dd><input type="hidden" name="id" value="<?php echo h($response['id']); ?>" /></dd>
      </dl>
      <input type="submit" value="Save response" />
    </form>

    <a 
      class="action" 
      href="<?php echo url_for('/artifacts/response-delete.php?id=' . h(u($response['id']))); ?>"
    >
      <button>
        Delete Aversion
      </button>
    </a>

  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
