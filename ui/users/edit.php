<?php

require_once('../../private/initialize.php');
require_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/users/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  // Handle form values sent by new.php

  $player = [];
  $player['id'] = $id ?? '';
  $player['FirstName'] = $_POST['FirstName'] ?? '';
  $player['LastName'] = $_POST['LastName'] ?? '';
  $player['G'] = $_POST['G'] ?? '';
  $player['Age'] = $_POST['Age'] ?? '';

  $result = update_player($player);
  if($result === true) {
    $_SESSION['message'] = 'The player was updated successfully.';
    redirect_to(url_for('/users/show.php?id=' . $id));
  } else {
    $errors = $result;
  }

} else {

  $player = find_player_by_id($id);

}

?>

<?php $page_title = 'Edit User'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<main>

  <div class="object edit">
    <h1><?php echo $page_title; ?></h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/users/edit.php?id=' . h(u($id))); ?>" method="post">

      <label for="FirstName">First Name</label>
      <input 
        type="text" 
        name="FirstName" 
        id="FirstName"
        value="<?php echo h($player['FirstName']); ?>" 
      />

      <label for="LastName">Last Name</label>
      <input 
        type="text" 
        id="LastName"
        name="LastName" 
        value="<?php echo h($player['LastName']); ?>" 
      />

      <label for="Gender">Gender (M, F, or Other)</label>
      <input type="text" id="Gender" name="G" value="<?php echo h($player['G']); ?>" />

      <label for="Age">Age</dt>
      <input type="text" id="Age" name="Age" value="<?php echo h($player['Age']); ?>" />

      <input type="submit" value="Save Edits" />

    </form>

  </div>

  <section>
    <?php
    $sql = "SELECT 
      responses.PlayDate, 
      responses.id as responseID,
      games.Title,
      games.id AS artifactID
      FROM responses 
      JOIN games ON games.id = responses.Title
      WHERE responses.Player = '" . $_REQUEST['id'] . "' 
      ORDER BY responses.PlayDate DESC
    ";
    $resultObject = mysqli_query($db, $sql);
    ?>
    <h2>
      <?php echo $resultObject->num_rows; ?>
      <?php echo h($player['FullName']); ?>
      uses are recorded 
    </h2>
    <table>
      <tr>
        <th>Use Date (<?php echo $resultObject->num_rows; ?>)</th>
        <th>Artifact</th>
      <tr>
      <?php foreach ($resultObject as $resultArray) { ?>        
        <tr>
          <td>
            <a href="/uses/edit.php?id=<?php echo $resultArray['responseID']; ?>">
              <?php echo $resultArray['PlayDate']; ?>
            </a>
          </td>
          <td>
            <a href="/artifacts/edit.php?id=<?php echo $resultArray['artifactID']; ?>">
              <?php echo $resultArray['Title']; ?>
            </a>
          </td>
        </tr>
      <?php } ?>
    </table>
  </section>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
