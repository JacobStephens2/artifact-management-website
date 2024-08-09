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
      <a href="/types/new">
        <button>New</button>
      </a>
    </div>

  	<table class="list" data-page-length='100'>

      <thead>
        <tr id="headerRow">
          <th>Type</th>
          <th>Artifacts Kept</th>
          <th>Artifacts Not Kept</th>
        </tr>
      </thead>

      <tbody>
        <?php 
          $user_id = $_SESSION['user_id'];
          echo $user_id;
          $types = query("SELECT id, ObjectType FROM types WHERE user_id = '$user_id'");

          foreach($types as $type) { 
            
            $type_name = $type['ObjectType'];
            $type_id = $type['id'];

            $query = 
              "SELECT COUNT(id) AS artifacts_kept_of_this_type
              FROM games
              WHERE type_id = '$type_id'
              AND user_id = '$user_id'
              AND KeptCol = '1'
            ";
            $artifacts_kept_of_this_type = singleValueQuery($query);

            $artifacts_unkept_of_this_type = singleValueQuery(
              "SELECT COUNT(id) AS artifacts_kept_of_this_type
              FROM games
              WHERE type_id = '$type_id'
              AND user_id = '$user_id'
              AND KeptCol = '0'
            ");
            ?>
            
            <tr>
              <td>
                <a href="/types/edit?id=<?php echo $type['id']; ?>">
                  <?php echo h($type_name); ?>
                </a>
              </td>
              <td>
                <a href="/artifacts/?type=<?php echo $type['id']; ?>&kept=yes">
                  <?php echo h($artifacts_kept_of_this_type); ?>
                </a>
              </td>
              <td>
                <a href="/artifacts/?type=<?php echo $type['id']; ?>&kept=no">
                  <?php echo h($artifacts_unkept_of_this_type); ?>
                </a>
              </td>
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
          [ 2, 'desc'], // count unkept
          [ 0, 'asc'] // name
        ], 
      });
    </script>
  </div>

</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
