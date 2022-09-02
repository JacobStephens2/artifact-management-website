<?php
require_once('../../private/initialize.php');
require_login();
$id = $_GET['id'] ?? '1'; // PHP > 7.0
$player = find_player_by_id($id);
$page_title = 'Show User';
include(SHARED_PATH . '/header.php'); 
?>

<main>

  <div class="object show">

    <h1>Name: <?php echo h($player['FirstName']) . ' ' . h($player['LastName']); ?></h1>

    <div class="attributes">
      <dl>
        <dt>Gender</dt>
        <dd><?php echo h($player['G']); ?></dd>
      </dl>
      <dl>
        <dt>Age</dt>
        <dd><?php echo h($player['Age']); ?></dd>
      </dl>
    </div>

    <hr />

  </div>

</main>
