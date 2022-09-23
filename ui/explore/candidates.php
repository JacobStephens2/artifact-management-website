<?php 

require_once('../../private/initialize.php');

require_login();

$page_title = 'Candidates';

include(SHARED_PATH . '/header.php');

$sql = "SELECT * 
FROM games
WHERE Candidate IS NOT NULL
AND Candidate != '0'
AND Candidate != ''
AND user_id = " . $_SESSION['user_id'] . "
ORDER BY Candidate ASC
";

$resultObject = mysqli_query($db, $sql);

?>

<main>

  <h1>
    <?php echo $page_title; ?>
  </h1>

  <table>

    <tr>
      <th>User Count</th>
      <th>Artifact</th>
      <th>Type</th>
    </tr>

    <?php foreach ($resultObject as $row) { ?>
      <tr>
        <td>
          <?php echo $row['Candidate']; ?>
        </td>
        <td>
          <a href="/artifacts/edit.php?id=<?php echo $row['id']; ?>">
            <?php echo $row['Title']; ?>
          </a>
        </td>
        <td>
          <?php echo $row['type']; ?>
        </td>
      </tr>
    <?php } ?>

  </table>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>