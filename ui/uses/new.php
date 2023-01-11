<?php
require_once('../../private/initialize.php');
require_login();

if(is_post_request()) {

  ?>
  <?php

  $response = [];
  $response['Title'] = $_POST['Title'] ?? '';
  $response['PlayDate'] = $_POST['PlayDate'] ?? '';
  $response['Note'] = $_POST['Note'] ?? '';

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

  // $result = insert_response($response, $playerCount);

  // if($result === true) {
  //   $new_id = mysqli_insert_id($db);
  //   $_SESSION['message'] = "The response was recorded successfully.";
  //   redirect_to(url_for('/uses/create.php'));
  // } else {
  //   $errors = $result;
  // }

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

<script type="module" src="modules/searchArtifactsList.js"></script>
<script type="module" src="modules/searchUsersList.js"></script>
<script type="module" src="modules/getUsers.js"></script>

<main>

  <?php
    if (is_post_request()) {
      ?>
      <pre>$_POST: <?php print_r($_POST); ?></pre>
      <?php
    }
  ?>

  <h1>
    <?php echo $page_title; ?>
  </h1>

  <form action="new.php" method="post">
    
    <label for="date">Date</label>
    <input type="date" name="use[date]" id="date" 
      value="<?php echo date('Y-m-d'); ?>"  
    >

    <label for="SearchTitles">Search Artifacts</label>
    <input type="search" id="SearchTitles" name="searchTitle" value="">
    <input type="hidden" id="SearchTitleSubmission" name="searchTitleID" value="">
    <div class="searchResults" style="display: none;">
      <ul class="searchResults" style="margin-top: 0;">
        <li></li>
      </ul>
    </div>

    <label for="users">Users List</label>
    <section id="users">
      <input type="search" class="user" id="user0name" name="user[][name]" value="">
      <input type="hidden" id="user0id" name="user[][id]" value="">
      <div class="userResults" style="display: none;">
        <ul class="userResults" style="margin-top: 0;">
          <li></li>
        </ul>
      </div>
    </section>

    <label for="Users">Users</label>
    <section id="sweetSpots">
      <div>
        <input type="hidden" name="User[][id]" value="<?php echo $_SESSION['player_id']; ?>">
        <input 
          class="sweetSpot"
          type="text" 
          id="User" 
          value="<?php echo $_SESSION['FullName']; ?>"
        >
      </div>
    </section>

    <button 
      id="addUser"
      class="user"
      style="display: block;"
      >
      +
    </button>

    <input type="submit" value="Submit">

  </form>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>