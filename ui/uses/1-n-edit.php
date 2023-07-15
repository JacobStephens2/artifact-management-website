<?php
require_once('../../private/initialize.php');
require_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/uses/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {
  // handle post requests sent by this page
  $response = [];
  $response['use_id'] = $id ?? '';
  $response['artifact_id'] = $_POST['artifact_id'] ?? '';
  $response['use_date'] = $_POST['use_date'] ?? '';
  $response['user'] = $_POST['user'] ?? '';
  $response['note'] = $_POST['note'] ?? '';

  $result = update_use($response);
  if($result === true) {
    $_SESSION['message'] = 'The use was updated successfully.';
  } else {
    $errors = $result;
  }

  $response = find_use_details_by_id($id);

} else {
  $response = find_use_details_by_id($id);
}

$page_title = 'Edit 1:n Use';
include(SHARED_PATH . '/header.php'); 
?>

<main>

  <div class="object edit">

    <h1><?php echo $page_title; ?></h1>

    <?php echo display_errors($errors); ?>

    <form 
      action="<?php echo url_for('/uses/1-n-edit.php?id=' . h(u($id))); ?>" 
      method="post"
      >

      <label for="Title">Artifact</label>
      <select id="Title" name="artifact_id">
        <?php
          $artifact_set = list_games();
          while($artifact = mysqli_fetch_assoc($artifact_set)) {
            echo "<option value=\"" . h($artifact['id']) . "\"";
            if($response["game_id"] == $artifact['id']) {
              echo " selected";
            }
            echo ">" . h($artifact['Title']) . "</option>";
          }
          mysqli_free_result($artifact_set);
        ?>
      </select>

      <label for="user">User(s)</dt>
      <?php
          $usersResultObject = find_users_by_use_id($response['id']);

          $playersResultObject = list_players();

          $i = 0;
          foreach ($usersResultObject as $user) {
            ?>
            <select id="user" name="user[<?php echo $i; ?>]">
              <option value='Invalid'>Choose a User</option>
              <?php
              foreach($playersResultObject as $player) {
                echo "<option value=\"" . h($player['id']) . "\"";
                if($user["id"] == $player['id']) {
                  echo " selected";
                }
                echo ">" . h($player['FirstName']) . ' ' . h($player['LastName']) . "</option>";
              }
              ?>
            </select>
            <?php
            $i++;
          }
          mysqli_free_result($playersResultObject);
          mysqli_free_result($usersResultObject);
        ?>
      
      <label for="UseDate">Use Date</dt>
      <input 
        type="date" 
        id="UseDate" 
        name="use_date" 
        value="<?php echo h(substr($response['use_date'],0,10)); ?>" 
      />

      <label for="Note">Note</label>
      <textarea 
        name="note" 
        id="Note" 
        cols="30" 
        rows="10"
        ><?php echo h($response['note']); ?></textarea>
      
      <input type="hidden" name="use_id" value="<?php echo h($response['id']); ?>" /></dd>

      <input type="submit" value="Save response" />

    </form>

  </div>

  <a 
    class="action" 
    href="<?php echo url_for('/uses/delete.php?id=' . h(u($response['id']))); ?>"
  >
    <button>
      Delete Use
    </button>
  </a>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
