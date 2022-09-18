<?php 

require_once('../../private/initialize.php');

require_login();

$page_title = 'Uses By Artifact';

include(SHARED_PATH . '/header.php');

$getUseCountsByPlayerSQL = "SELECT 
  COUNT('responses.PlayDate') AS CountOfUses, 
  games.Title
  FROM responses
  JOIN games ON games.id = responses.Title
  WHERE responses.Player = " . $_SESSION['player_id'] . "
  GROUP BY responses.Title
  ORDER BY CountOfUses DESC
";

$usesByPlayerResultObject = mysqli_query($db, $getUseCountsByPlayerSQL);

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

  <table>

    <tr>
      <th>Uses</th>
      <th>Artifact</th>
    </tr>

    <?php foreach ($usesByPlayerResultObject as $usesByPlayerArray) { ?>
      <tr>
        <td>
          <?php echo $usesByPlayerArray['CountOfUses']; ?>
        </td>
        <td>
          <?php echo $usesByPlayerArray['Title']; ?>
        </td>
      </tr>
    <?php } ?>

  </table>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>