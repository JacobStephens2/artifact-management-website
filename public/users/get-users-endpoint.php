<?php
require_once('../../private/initialize.php');
header('Content-Type: application/json');

$authentication_response = authenticate();
if ($authentication_response->authenticated != true) {
  echo json_encode($authentication_response);
  exit;
}

$requestBody = json_decode(
  file_get_contents('php://input')
);

if (isset($requestBody->query)) {
  $game_set = list_users_by_query($requestBody->query);
} else {
  $game_set = list_players();
}

$game = mysqli_fetch_assoc($game_set);

if ($game_set->num_rows == 1) {

  $game_array[] = $game;

} else {

  while($game = mysqli_fetch_assoc($game_set)) {
    $game_array[] = $game;
  }

}

echo json_encode($game_array);

mysqli_free_result($game_set);
?>