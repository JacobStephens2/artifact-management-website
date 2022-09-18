<?php 

require_once('../../private/initialize.php');

require_login();

$page_title = 'Uses By Artifact';

include(SHARED_PATH . '/header.php');

$getUsesByPlayerSQL = "SELECT 
  COUNT('responses.PlayDate') AS Uses, 
  games.Title
  FROM responses
  JOIN games ON games.id = responses.Title
  WHERE responses.Player = " . $_SESSION['player_id'] . "
  GROUP BY responses.Title
  ORDER BY Uses DESC
";

$usesByPlayerResultObject = mysqli_query($db, $getUsesByPlayerSQL);

// find the last letter of the name
// and set fitting punctuation
if (substr($_SESSION['FullName'], -1, 1) == 's') {
  $possessivePunctuation = "' ";
} else {
  $possessivePunctuation = "'s ";
}

?>

<main>
  
  <h1>
    <?php echo $_SESSION['FullName'] . $possessivePunctuation . $page_title; ?>
  </h1>

  <pre>
    <?php
    foreach ($usesByPlayerResultObject as $usesByPlayerArray) {
      print_r($usesByPlayerArray); 
    }
    ?>
  </pre>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>