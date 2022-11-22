<?php 

require_once('../../private/initialize.php');

require_login();

$page_title = 'Uses By Artifact Over Last 365 Days';

include(SHARED_PATH . '/header.php');

$getUseCountsByPlayerSQL = "SELECT 
  COUNT('responses.PlayDate') AS CountOfUses, 
  games.Title AS ArtifactTitle,
  responses.Title AS ArtifactID,
  games.type AS ArtifactType
  FROM responses
  JOIN games ON games.id = responses.Title
  WHERE responses.Player = " . $_SESSION['player_id'] . "
  AND responses.PlayDate > DATE_SUB(NOW(), INTERVAL 365 DAY)
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

  <a href="uses-by-artifact.php">
    <p>All Uses By Artifact</p>
  </a>

  <table>

    <tr>
      <th>Rank</th>
      <th>Uses</th>
      <th>Artifact</th>
      <th>Type</th>
    </tr>

    <?php 
    $i = 1;
    foreach ($usesByPlayerResultObject as $usesByPlayerArray) { 
      ?>
      <tr>
        <td>
          <?php echo $i; ?>
        </td>
        <td>
          <?php echo $usesByPlayerArray['CountOfUses']; ?>
        </td>
        <td>
          <a href="/artifacts/edit.php?id=<?php echo $usesByPlayerArray['ArtifactID']; ?>">
            <?php echo $usesByPlayerArray['ArtifactTitle']; ?>
          </a>
        </td>
        <td>
          <?php echo $usesByPlayerArray['ArtifactType']; ?>
        </td>
      </tr>
      <?php 
      $i++;
    } 
    ?>

  </table>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>