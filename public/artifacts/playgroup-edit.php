<?php

require_once('../../artifacts_private/initialize.php');
require_login();

if(!isset($_GET['ID'])) {
  redirect_to(url_for('/artifacts/playgroup.php'));
}
$ID = $_GET['ID'];

if(is_post_request()) {

  // Handle form values sent by new.php

  $playgroupplayer = [];
  $playgroupplayer['ID'] = $ID ?? '';
  $playgroupplayer['FullName'] = $_POST['FullName'] ?? '';

  $result = update_playgroup_player($playgroupplayer);
  if($result === true) {
    $_SESSION['message'] = 'The playgroup player was updated successfully.';
    redirect_to(url_for('/artifacts/playgroup.php?'));
  } else {
    $errors = $result;
    //var_dump($errors);
  }

} else {

  $playgroupplayer = find_playgroup_player_by_id($ID);

}

?>

<?php $page_title = 'Edit playgroup player'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main>

  <li><a class="back-link" href="<?php echo url_for('/artifacts/playgroup.php'); ?>">&laquo; To playgroup</a></li>
  <li><a class="back-link" href="<?php echo url_for('/artifacts/playby.php'); ?>">&laquo; To Use Artifacts by Date List</a></li>

  <div class="object edit">
    <h1>Edit playgroup player</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/artifacts/playgroup-edit.php?ID=' . h(u($ID))); ?>" method="post">
    <dl>
        <dt>Player</dt>
        <dd>
          <select name="FullName">
            <option value='Invalid'>Choose a player</option>
          <?php
            $player_set = list_players();
            while($player = mysqli_fetch_assoc($player_set)) {
              echo "<option value=\"" . h($player['id']) . "\"";
              if($playgroupplayer['FullName'] == $player['id']) {
                echo " selected";
              }
              echo ">" . h($player['FirstName']) . ' ' . h($player['LastName']) . "</option>";
            }
            mysqli_free_result($player_set);
          ?>
          </select>
        </dd>
      </dl>
      <div ID="operations">
        <input type="submit" value="Save playgroup player edit" />
      </div>
    </form>

  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
