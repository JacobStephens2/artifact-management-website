<?php
require_once('../../private/initialize.php');
require_login();
$page_title = 'Record Use';
include(SHARED_PATH . '/header.php'); 
?>

<script type="module" src="modules/getArtifacts.js"></script>
<script type="module" src="modules/searchArtifacts.js"></script>
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
    <input type="text" name="SearchTitles" id="SearchTitles">

    <label for="Users">Users</label>
    <section id="sweetSpots">
      <div>
        <input type="hidden" name="User[0]" value="<?php echo $_SESSION['player_id']; ?>">
        <input 
          class="sweetSpot"
          type="text" 
          name="User[0][Name]" 
          id="User0" 
          value="<?php echo $_SESSION['FullName']; ?>"
        >
      </div>
    </section>

    <button 
      id="addSweetSpot"
      class="sweetSpot"
      style="display: block;"
      >
      +
    </button>

    <input type="submit" value="Submit">

  </form>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>