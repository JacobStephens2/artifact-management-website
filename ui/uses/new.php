<?php
require_once('../../private/initialize.php');
require_login();
$page_title = 'Record Use';
include(SHARED_PATH . '/header.php'); 
?>

<script type="module" src="modules/getArtifacts.js"></script>
<script type="module" src="modules/searchArtifactsList.js"></script>
<script type="module" src="modules/getUsers.js"></script>

<main>

  <h1>
    <?php echo $page_title; ?>
  </h1>

  <form action="new-use.php" method="post">
    
    <label for="date">Date</label>
    <input type="date" name="use[date]" id="date" 
      value="<?php echo date('Y-m-d'); ?>"  
    >

    <label for="Title">Artifact</label>
    <select name="Title" id="Title">
    </select>

    <label for="SearchTitles">Search Artifacts</label>
    <input type="search" id="SearchTitles" name="searchTitle" value="test">
    <div class="searchResults" style="display: none;">
      <ul class="searchResults" style="margin-top: 0;">
        <li id="result0" value="1">One</li>
        <li id="result1" value="2">Two</li>
      </ul>
    </div>

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