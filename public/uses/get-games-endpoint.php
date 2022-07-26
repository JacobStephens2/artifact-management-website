<?php
require_once('../../artifacts_private/initialize.php');
require_api_key();

header('Content-Type: application/json');

$game_set = list_games();

$game = mysqli_fetch_assoc($game_set);

while($game = mysqli_fetch_assoc($game_set)) {
  $game_array[] = $game;
}

echo json_encode($game_array);

mysqli_free_result($game_set);
?>