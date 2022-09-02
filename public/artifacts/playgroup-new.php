<?php

require_once('../../private/initialize.php');
require_login();

if(is_post_request()) {

  $response = [];
  $response['playerCount'] = $_POST['playerCount'] ?? '1';
  $playerCount = $response['playerCount'];
  
  $i = 1;
  while ($playerCount >= $i) {
    $response['Player' . $i] = $_POST['Player' . $i] ?? '';
    $i++;
  }

  $result = insert_playgroup($response);
  if($result === true) {
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'The playgroup was successfully expanded.';
    redirect_to(url_for('/artifacts/playgroup.php'));
  } else {
    $errors = $result;
  }

} else {
  // display the blank form
  $response = [];
  $response["FullName"] = '';
  $playerCount = $_GET['playerCount'] ?? '1';

}



if(is_post_request()) {

  $object = [];
  $object['FullName'] = $_POST['FullName'] ?? '';

  $result = insert_playgroup($object);
  if($result === true) {
    $_SESSION['message'] = 'The object was created successfully.';
    redirect_to(url_for('/artifacts/playgroup.php'));
  } else {
    $errors = $result;
  }

} else {
  // display the blank form
  $object = [];
  $object["FullName"] = '';
}

?>

<?php $page_title = 'Create object'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main>

  <a class="back-link" href="<?php echo url_for('/artifacts/playgroup.php'); ?>">&laquo; Back to List</a>

  <h2>Player count</h2>
    <form action="<?php echo url_for('/artifacts/playgroup-new.php'); ?>" method="get">
      <select name="playerCount">
        <?php
          $i = 1;
          while ($i < 10) {
            echo "<option value=\"" . $i . "\"";
            if($i == $playerCount) {
              echo " selected";
            }
            echo ">" . $i . "</option>";
            $i++;
          }
        ?>
      </select>
      <input type="submit" value="Select player count" />
    </form>


  <div class="object new">
    <h1>Add to playgroup</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/artifacts/playgroup-new.php'); ?>" method="post">
      <dl>
        <dd>
        <select name="Player1">
            <option value='141'>Jacob Stephens</option>
          <?php
            $player_set = list_players();
            while($player = mysqli_fetch_assoc($player_set)) {
              echo "<option value=\"" . h($player['id']) . "\"";
              echo ">" . h($player['FirstName']) . ' ' . h($player['LastName']) . "</option>";
            }
            mysqli_free_result($player_set);
          ?>
          </select>
        </dd>

        <?php
          $i = 1;
          $p = 2;
          while ($playerCount > $i) {
            echo '<dd><select name="Player' . $p . '"><option value="">Choose a player</option>'; 
            $player_set = list_players();
            while($player = mysqli_fetch_assoc($player_set)) {
              echo "<option value=\"" . h($player['id']) . "\"";
              echo ">" . h($player['FirstName']) . ' ' . h($player['LastName']) . "</option>";
            }
            mysqli_free_result($player_set);            
            echo '</select></dd>';
            $i++;
            $p++;
          }
        ?>
      </dl>
      <input type="hidden" name="playerCount" value="<?php echo $playerCount; ?>">
      <div id="operations">
        <input type="submit" value="Add to playgroup" />
      </div>
    </form>

  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
