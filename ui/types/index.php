<?php 
  require_once('../../private/initialize.php');
  require_login();

  $page_title = 'Types';
  
  include(SHARED_PATH . '/header.php'); 
  include(SHARED_PATH . '/dataTable.html');
?>

<style>
  .tooltip:hover {
    background: black;
  }
</style>

<main>
  <div class="objects listing">

    <div style="display: flex;
      justify-content: space-between;"
      >
      <h1>Types</h1>
    </div>

  	<table class="list" data-page-length='100'>

      <thead>
        <tr id="headerRow">
          <th>Type</th>
          <th>Artifacts Kept</th>
        </tr>
      </thead>

      <tbody>
        <?php 
          $user_id = $_SESSION['user_id'];
          $types = query("SELECT ObjectType FROM types WHERE user_id = '$user_id'");

          foreach($types as $type) { 
            
            $type_name = $type['ObjectType'];

            $artifacts_kept_of_this_type = singleValueQuery(
              "SELECT COUNT(id) AS artifacts_kept_of_this_type
              FROM games
              WHERE type = '$type_name'
              AND user_id = '$user_id'
              AND KeptCol = '1'
            ");
            ?>
            
            <tr>
              <td><?php echo h($type_name); ?></td>            
              <td><?php echo h($artifacts_kept_of_this_type); ?></td>            
            </tr>
            
            <?php 
          } 
        ?>
      </tbody>
  	</table>

    <script>
      let table = new DataTable('table', {
        // options
        order: [
          [ 1, 'desc'], // count kept
          [ 0, 'asc'] // artifact type
        ], 
      });
    </script>
  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
