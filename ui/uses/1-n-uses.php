<?php 
  require_once('../../private/initialize.php');
  require_login();
  $use_set = find_uses_by_user_id();
  $page_title = '1:n Artifact Uses';
  include(SHARED_PATH . '/header.php');
  include(SHARED_PATH . '/dataTable.html');
?>

<main>
    <h1><?php echo $page_title; ?></h1>

  	<table class="list" id="uses" data-page-length='100'>
      <thead>
        <tr id="headerRow">
          <th>Use Date (<?php echo $use_set->num_rows; ?>)</th>
          <th>Title</th>
          <th>User Count</th>
          <th>Users</th>
          <th>Type</th>
        </tr>
      </thead>

      <tbody>
        <?php while($use = mysqli_fetch_assoc($use_set)) { ?>
          <?php $usersResultObject = find_users_by_use_id($use['useID']); ?>
          <tr>
            <td class="date">
              <a 
                class="action" 
                href="<?php echo url_for('/uses/1-n-edit.php?id=' . h(u($use['useID']))); ?>"
                >
                <?php echo h(substr($use['use_date'],0,10)); ?>
              </a>
            </td>
            
            <td>
              <a 
                class="action" 
                href="<?php echo url_for('/uses/1-n-edit.php?id=' . h(u($use['useID']))); ?>"
                >
                <?php echo h($use['Title']); ?>
              </a>
            </td>

            <td>
              <?php echo $usersResultObject->num_rows; ?>
            </td>

            <td>
              <?php 
                $i = 0;
                foreach ($usersResultObject as $user) {
                  $i++;
                  echo $user['FirstName'] . ' ' . $user['LastName'];
                  if ($i != $usersResultObject->num_rows) {
                    echo ', ';
                  }
                }
              ?>
            </td>
                        
            <td class="type">
              <?php echo h($use['type']); ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
  	</table>

    <?php mysqli_free_result($use_set); ?>

    <script>
      let table = new DataTable('#uses', {
        // options
        order: [
          [ 0, 'desc'] // Most recent first
        ]
      });
    </script>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
