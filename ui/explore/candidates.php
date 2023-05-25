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
ORDER BY type ASC,
Candidate ASC
";

$resultObject = mysqli_query($db, $sql);

?>

<main>

  <h1>
    <?php echo $page_title; ?>
  </h1>

  <table>

    <tr>
      <th>Type</th>
      <th>Category</th>
      <th>Artifact</th>
      <th>MnP</th>
      <th>MxP</th>
      <th>SS</th>
      <th>MnT</th>
      <th>MxT</th>
    </tr>

    <?php foreach ($resultObject as $row) { ?>
      <tr>
        <td>
          <?php echo $row['type']; ?>
        </td>
        <td>
          <?php echo $row['Candidate']; ?>
        </td>
        <td>
          <a href="/artifacts/edit.php?id=<?php echo $row['id']; ?>">
            <?php echo $row['Title']; ?>
          </a>
        </td>
        <td>
          <?php echo $row['MnP']; ?>
        </td>
        <td>
          <?php echo $row['MxP']; ?>
        </td>
        <td>
          <?php echo $row['SS']; ?>
        </td>
        <td>
          <?php echo $row['MnT']; ?>
        </td>
        <td>
          <?php echo $row['MxT']; ?>
        </td>
      </tr>
    <?php } ?>

  </table>

  <label for="typeOptions">Type Options</label>
  <select id="typeOptions">
    <?php 
      $type = '';
      include(SHARED_PATH . '/artifact_type_options.php'); 
    ?>
  </select>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>