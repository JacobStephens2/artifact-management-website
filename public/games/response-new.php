<?php
require_once('../../artifacts_private/initialize.php');
require_login();

if(is_post_request()) {
  $response = [];
  $response['Title'] = $_POST['Title'] ?? '';
  $response['PlayDate'] = $_POST['PlayDate'] ?? '';
  $response['Player1'] = $_POST['Player1'] ?? '';
  $response['Player2'] = $_POST['Player2'] ?? '';
  $response['Player3'] = $_POST['Player3'] ?? '';
  $response['Player4'] = $_POST['Player4'] ?? '';
  $response['Player5'] = $_POST['Player5'] ?? '';
  $response['Player6'] = $_POST['Player6'] ?? '';
  $response['Player7'] = $_POST['Player7'] ?? '';
  $response['Player8'] = $_POST['Player8'] ?? '';
  $response['Player9'] = $_POST['Player9'] ?? '';
  $response['PlayerCount'] = 1;

  if($response['Player9'] != '') {
    $response['PlayerCount'] = 9;
  } elseif ($response['Player8'] != '') {
    $response['PlayerCount'] = 8;    
  } elseif ($response['Player7'] != '') {
    $response['PlayerCount'] = 7;
  } elseif ($response['Player6'] != '') {
    $response['PlayerCount'] = 6;
  } elseif ($response['Player5'] != '') {
    $response['PlayerCount'] = 5;
  } elseif ($response['Player4'] != '') {
    $response['PlayerCount'] = 4;
  } elseif ($response['Player3'] != '') {
    $response['PlayerCount'] = 3;
  } elseif ($response['Player2'] != '') {    
    $response['PlayerCount'] = 2;
  } else {    
    $response['PlayerCount'] = 1;
  } 

  $result = insert_response($response);
  $playerCount = $response['PlayerCount'];
  if($result === true) {
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = "The response was recorded successfully.";
    redirect_to(url_for('/games/response-new.php'));
  } else {
    $errors = $result;
  }

} else {
  // display the blank form
  $response = [];
  $response["Title"] = '';
  $response["PlayDate"] = '';
  $response["Player"] = '';
  $playerCount = $_GET['playerCount'] ?? '';
}
?>

<?php $page_title = 'Record Use'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<main>
  <li>
		<a class="back-link" href="<?php echo url_for('/games/index.php'); ?>">&laquo; Games</a>
	</li>
  <li>
		<a class="back-link" href="<?php echo url_for('/games/playby.php'); ?>">&laquo; Play games by date</a>
	</li>
  <li>
		<a class="back-link" href="<?php echo url_for('/games/responses.php'); ?>">&laquo; Responses</a>
	</li>

    <h1>Record Response</h1>

    <form action="<?php echo url_for('/games/response-new.php'); ?>" method="get">
			<label for="playerCount">User Count</label>
      <select name="playerCount" id="playerCount">
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
      <input type="submit" value="Select user count" />
    </form>

    <form action="<?php echo url_for('/games/response-new.php'); ?>" method="post">

			<label for="Title">Artifact</label>
			<select name="Title" id="Title">
				<!-- Identifies next play by game -->
				<?php 
					$first_set = first_play_by(); 
					while($first = mysqli_fetch_assoc($first_set)) {
						$title = h($first['Title']);
					}
					mysqli_free_result($first_set);
					$game_set = list_games();
					while($game = mysqli_fetch_assoc($game_set)) {
						echo "<option value=\"" . h($game['id']) . "\"";
							if($title == $game['Title']) {
								echo " selected";
							}
						echo ">";
							echo h($game['Title']);
						echo "</option>";
					}
					mysqli_free_result($game_set);
				?>
			</select>

			<label for="PlayDate">Response Date</label>
			<input 
				type="date" 
				id="PlayDate" 
				name="PlayDate" 
				value="<?php echo date('Y') . '-' . date('m') . '-' . date('d'); ?>"
			/>

			<label for="Users">
				<?php
					if ($playerCount > 1) {
						echo 'Users';
					} else {
						echo 'User';
					}
				?>
			</label>

			<!-- Choose players -->
			<select id="Users" name="Player1">
				<option value='141'>Jacob Stephens</option>
				<?php
					$player_set = list_players();
					while($player = mysqli_fetch_assoc($player_set)) {
						echo "<option value=\"" . h($player['id']) . "\">";
							echo h($player['FirstName']) . ' ' . h($player['LastName']);
						echo "</option>";
					}
					mysqli_free_result($player_set);
				?>
			</select>

      <?php
        $i = 1;
        $p = 2;
        while ($playerCount > $i) { ?>
          <select name="Player'<?php echo $p; ?>">
            <option value="">Choose a player</option>
            <?php
            $player_set = list_players();
            while($player = mysqli_fetch_assoc($player_set)) {
              echo "<option value=\"" . h($player['id']) . "\">";
                echo h($player['FirstName']) . ' ' . h($player['LastName']);
              echo "</option>";
            }
						mysqli_free_result($player_set); ?>     
          </select> <?php
          $i++;
          $p++;
        }
      ?>

			<input type="submit" value="Record Use" />

    </form>

</main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>