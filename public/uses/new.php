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

  $playerCount = $_GET['playerCount'] ?? 1;

  $result = insert_response($response, $playerCount);

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
  $playerCount = $_GET['playerCount'] ?? 1;
}

$page_title = 'Record Use';
include(SHARED_PATH . '/staff_header.php'); 

?>

<main>
  <li>
		<a class="back-link" href="<?php echo url_for('/games/index.php'); ?>">&laquo; Artifacts</a>
	</li>
  <li>
		<a class="back-link" href="<?php echo url_for('/games/playby.php'); ?>">&laquo; Use Artifacts By Date</a>
	</li>
  <li>
		<a class="back-link" href="<?php echo url_for('/games/responses.php'); ?>">&laquo; Uses</a>
	</li>

    <h1>Record Use</h1>

    <form 
      action="<?php echo url_for('/games/response-new.php'); ?>"
      method="get"
    >
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
      <input type="submit" value="Select User Count" />
    </form>

    <form action="<?php echo url_for('/games/response-new.php?playerCount=' . $playerCount); ?>" method="post">

      <!-- This select gets populated by the JavaScript fetch request above -->
      <label for="SearchTitles">Search Artifacts</label>
      <input type="text" name="SearchTitles" id="SearchTitles">
      

			<label for="Title">Artifact</label>
			<select name="Title" id="Title">
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
				<option value='141'>
          Jacob Stephens
        </option>
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
          <select name="Player<?php echo $p; ?>">
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

    <!-- Append options to artifact select element -->
    <script defer>
      function search(e) {
        fetch('get-games-endpoint.php?query=' + e.target.value, {
          credentials: 'include',
        })
          .then((response) => response.json())
          .then(
            (data => {
              console.log(data);
              const titleSelect = document.querySelector('select#Title');
              titleSelect.innerHTML = '';
              for (let i in data) {
                let option = document.createElement('option');
                option.value = data[i].id;
                option.innerText = data[i].Title;
                titleSelect.append(option);
              }
            })
          )
        ;
      }
      const searchTitlesInput = document.querySelector('input#SearchTitles');
      searchTitlesInput.addEventListener('input', search);
    </script>

</main>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>