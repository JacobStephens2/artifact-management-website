<?php
require_once('../../private/initialize.php');
require_login();
$page_title = 'Record Use';
include(SHARED_PATH . '/header.php'); 
?>

<script type="module" src="modules/getArtifacts.js"></script>
<script type="module" src="modules/searchArtifacts.js"></script>

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

    <input type="submit" value="Submit">

  </form>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>