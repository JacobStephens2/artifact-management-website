<?php
require_once('../../private/initialize.php');
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
    redirect_to(url_for('/uses/create.php'));
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
include(SHARED_PATH . '/header.php'); 

?>

<main>

    <h1>Record Use</h1>

    <form 
      action="<?php echo url_for('/uses/create.php'); ?>"
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

    <form action="<?php echo url_for('/uses/create.php?playerCount=' . $playerCount); ?>" method="post">

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

      <label for="SearchUser1">Search Users</label>
      <input type="text" name="SearchUser1" id="SearchUser1">

			<!-- Choose players -->
			<select id="User1" name="Player1">
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
      <script>
        function searchUsers(e) {
          if (document.querySelector('#SearchUser1').value == '') {
            getArtifacts();
          } else {
            requestBody = {
              "query": e.target.value,
            };
            fetch('https://<?php echo API_ORIGIN; ?>/users.php', {
              method: 'POST',
              credentials: 'include',
              body: JSON.stringify(requestBody),
            })
              .then((response) => response.json())
              .then(
                (data => {
                  const userSelect = document.querySelector('select#User1');
                  userSelect.innerHTML = '';
                  for (let i = 0; i < data.users.length; i++) {
                    let option = document.createElement('option');
                    option.value = data.users[i].id;
                    option.innerText = data.users[i].FullName;
                    userSelect.append(option);
                  }
                })
              )
            ;
          }
        }
        const searchUsersInput = document.querySelector('input#SearchUser1');
        searchUsersInput.addEventListener('input', searchUsers);
      </script>

      <?php
        $i = 1;
        $p = 2;
        while ($playerCount > $i) { ?>
          <input type="text" name="SearchUser<?php echo $p; ?>" id="SearchUser<?php echo $p; ?>">

          <select id="User<?php echo $p; ?>" name="Player<?php echo $p; ?>">
            <option value="">Choose a player</option>
            <?php
            $player_set = list_players();
            while($player = mysqli_fetch_assoc($player_set)) {
              echo "<option value=\"" . h($player['id']) . "\">";
                echo h($player['FirstName']) . ' ' . h($player['LastName']);
              echo "</option>";
            }
						mysqli_free_result($player_set); ?>     
          </select>

          <script>
            function searchUsers(e) {
              if (document.querySelector('#SearchUser<?php echo $p; ?>').value == '') {
                getArtifacts();
              } else {
                requestBody = {
                  "query": e.target.value,
                };
                fetch('https://<?php echo API_ORIGIN; ?>/users.php', {
                  method: 'POST',
                  credentials: 'include',
                  body: JSON.stringify(requestBody),
                })
                  .then((response) => response.json())
                  .then(
                    (data => {
                      const userSelect = document.querySelector('select#User<?php echo $p; ?>');
                      userSelect.innerHTML = '';
                      for (let i = 0; i < data.users.length; i++) {
                        let option = document.createElement('option');
                        option.value = data.users[i].id;
                        option.innerText = data.users[i].FullName;
                        userSelect.append(option);
                      }
                    })
                  )
                ;
              }
            }
            const searchUser<?php echo $p; ?>Input = document.querySelector('input#SearchUser<?php echo $p; ?>');
            searchUser<?php echo $p; ?>Input.addEventListener('input', searchUsers);
          </script>
          <?php
          $i++;
          $p++;
        }
      ?>

			<input type="submit" value="Record Use" />

    </form>

    <!-- Append options to artifact and user select elements -->
    <script defer>
      function searchArtifacts(e) {
        if (document.querySelector('#SearchTitles').value == '') {
          getArtifacts();
        } else {
          requestBody = {
            "query": e.target.value,
          };
          fetch('https://<?php echo API_ORIGIN; ?>/artifacts.php', {
            method: 'POST',
            credentials: 'include',
            body: JSON.stringify(requestBody),
          })
            .then((response) => response.json())
            .then(
              (data => {
                const titleSelect = document.querySelector('select#Title');
                titleSelect.innerHTML = '';
                for (let i = 0; i < data.artifacts.length; i++) {
                  let option = document.createElement('option');
                  option.value = data.artifacts[i].id;
                  option.innerText = data.artifacts[i].Title;
                  titleSelect.append(option);
                }
              })
            )
          ;
        }
      }
      const searchTitlesInput = document.querySelector('input#SearchTitles');
      searchTitlesInput.addEventListener('input', searchArtifacts);

      function getArtifacts() {
        fetch('https://<?php echo API_ORIGIN; ?>/artifacts.php', {
          method: 'GET',
          credentials: 'include',
        })
          .then((response) => response.json())
          .then(
            (data => {
              const titleSelect = document.querySelector('select#Title');
              titleSelect.innerHTML = '';
              for (let i = 0; i < data.artifacts.length; i++) {
                let option = document.createElement('option');
                option.value = data.artifacts[i].id;
                option.innerText = data.artifacts[i].Title;
                titleSelect.append(option);
              }
            })
          )
        ;
      }
      getArtifacts();
    </script>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>