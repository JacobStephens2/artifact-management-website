<?php
require_once('../../private/initialize.php');
require_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/uses/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {
  // handle post requests sent by this page
  $response = [];
  $response['use_id'] = $id ?? '';
  $response['artifact_id'] = $_POST['artifact_id'] ?? '';
  $response['use_date'] = $_POST['use_date'] ?? '';
  $response['user'] = $_POST['user'] ?? '';
  $response['note'] = $_POST['note'] ?? '';
  $response['notesTwo'] = $_POST['notesTwo'] ?? '';

  $result = update_use($response);
  if($result === true) {
    $_SESSION['message'] = 'The use was updated successfully.';
  } else {
    $errors = $result;
  }

  $response = find_use_details_by_id($id);

} else {
  $response = find_use_details_by_id($id);
}

$page_title = 'Edit 1:n Use';
include(SHARED_PATH . '/header.php'); 

?>

<script type="module" src="modules/searchUsersList.js"></script>
<script type="module" src="modules/getUsers.js"></script>

<main>

  <div class="object edit">

    <h1><?php echo $page_title; ?></h1>

    <?php echo display_errors($errors); ?>

    <form 
      action="<?php echo url_for('/uses/1-n-edit.php?id=' . h(u($id))); ?>" 
      method="post"
      >

      <label for="UseDate">Use Date</dt>
      <input 
        type="date" 
        id="UseDate" 
        name="use_date" 
        value="<?php echo h(substr($response['use_date'],0,10)); ?>" 
      />

      <label for="Title">Artifact</label>
      <select id="Title" name="artifact_id">
        <?php
          $artifact_set = list_games();
          while($artifact = mysqli_fetch_assoc($artifact_set)) {
            echo "<option value=\"" . h($artifact['id']) . "\"";
            if($response["game_id"] == $artifact['id']) {
              echo " selected";
            }
            echo ">" . h($artifact['Title']) . "</option>";
          }
          mysqli_free_result($artifact_set);
        ?>
      </select>

      <?php
        $usersResultObject = find_users_by_use_id($response['id']);
      ?>

      <label for="users">Users List</label>
      <section id="users">
        <?php
        $i = 0;
        foreach ($usersResultObject as $user) {
          ?>
          <div class="sweetSpot">
            <input 
              type="search" 
              class="user" 
              id="user<?php echo $i; ?>name" 
              name="user[<?php echo $i; ?>][name]" 
              value="<?php echo $user['FirstName'] . ' ' . $user['LastName']; ?>"
              data-userid="<?php echo $_SESSION['user_id']; ?>"
              data-listposition="<?php echo $i; ?>"
            >
            <input 
              type="hidden" 
              id="user<?php echo $i; ?>id" 
              name="user[<?php echo $i; ?>][id]" 
              value="<?php echo $user['id']; ?>"
              data-listposition="<?php echo $i; ?>"
            >
            <div class="userResults user" id="userResultsDiv<?php echo $i; ?>" style="display: none;">
              <ul class="userResults user" id="userResults<?php echo $i; ?>" style="margin-top: 0;">
                <li></li>
              </ul>
            </div>
          </div>
          <?php
          $i++;
        }
        ?>

      </section>

      <button 
        id="addUser"
        class="user"
        style="display: block;"
        >
        +
      </button>

      
      

      <label for="Note">Setting</label>
      <input type="text"
        name="note" 
        id="Note" 
        value="<?php echo h($response['note']); ?>" 
      >

      <label for="notesTwo"></label>
      <textarea 
        name="notesTwo" 
        id="notesTwo" 
        cols="30" 
        rows="10"
        ><?php echo h($response['notesTwo']); ?></textarea>

      
      <input type="hidden" name="use_id" value="<?php echo h($response['id']); ?>" /></dd>

      <input type="submit" value="Save use" />

    </form>

  </div>

  <a 
    class="action" 
    href="<?php echo url_for('/uses/1-n-delete.php?id=' . h(u($response['id']))); ?>"
  >
    <button>
      Delete Use
    </button>
  </a>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
