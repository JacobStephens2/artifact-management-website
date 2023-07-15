<?php // initialize page

  require_once('../../private/initialize.php');

  require_login();

  $page_title = 'Candidates';

  include(SHARED_PATH . '/header.php');
  include(SHARED_PATH . '/dataTable.html'); 

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
    <?php echo $resultObject->num_rows . " " . $page_title; ?>
  </h1>

  <table id="candidates" data-page-length='100' class="list">

    <thead style="position: sticky; top: 0;">
      <tr>
        <th>Type</th>
        <th>Group and Setting</th>
        <th>Group Date</th>
        <th>Artifact (<?php echo $resultObject->num_rows; ?>)</th>
        <th>SS</th>
        <th>MnP</th>
        <th>MxP</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($resultObject as $row) { ?>
        <tr>
          <td>
            <?php echo $row['type']; ?>
          </td>
          <td>
            <?php echo $row['Candidate']; ?>
          </td>
          <td>
            <?php echo substr($row['CandidateGroupDate'], 0, 10); ?>
          </td>
          <td>
            <a href="/artifacts/edit.php?id=<?php echo $row['id']; ?>">
              <?php echo $row['Title']; ?>
            </a>
          </td>
          <td>
            <?php echo $row['SS']; ?>
          </td>
          <td>
            <?php echo $row['MnP']; ?>
          </td>
          <td>
            <?php echo $row['MxP']; ?>
          </td>
        </tr>
      <?php } ?>
    </tbody>

  </table>

  <label for="typeOptions">Type Options</label>
  <select id="typeOptions">
    <?php 
      $type = '';
      include(SHARED_PATH . '/artifact_type_options.php'); 
    ?>
  </select>

  <script>
    let table = new DataTable('#candidates', {
      // options
      order: [
        [ 2, 'asc'], // group date
        [ 0, 'asc'], // type
        [ 1, 'asc'], // group and setting
        [ 3, 'asc'], // SS
        [ 4, 'asc'], // MnP
        [ 5, 'asc'], // MxP
      ] 
    });
  </script>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>