<?php

require_once('../../../private/initialize.php');
require_login();

if(is_post_request()) {

  $use = [];
  $use['ObjectName'] = $_POST['ObjectName'] ?? '';
  $use['UseDate'] = $_POST['UseDate'] ?? '';

  $result = insert_use($use);
  if($result === true) {
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'The use was created successfully.';
    redirect_to(url_for('/staff/object_uses/show.php?id=' . $new_id));
  } else {
    $errors = $result;
  }

} else {
  // display the blank form
  $use = [];
  $use["ObjectName"] = '';
  $use["UseDate"] = '';
}

?>

<?php $page_title = 'Create Use'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/object_uses/index.php'); ?>">&laquo; Back to List</a>

  <div class="use new">

  <?php
  // $choices
  $choices = file('us_passenger_trains.txt', FILE_IGNORE_NEW_LINES);
  echo "<h2>1. Create choices variable array from trains.txt. Print array.</h2>";
  echo '$choices = ' . '<br><br>';
  echo '<pre>';
  print_r($choices);
  echo '</pre>';
  echo '<br><br> $choices has the following type: ' . gettype($choices);

  // $query
  echo "<h2>2. Create query variable string. Print string.</h2>";
  $query = "nor";
  echo '$query = ';
  print_r($query);
  echo '<br><br> $query has the following type: ' . gettype($query);


  // $suggestions
  function str_contains($choice, $query) {
    return strpos($choice, $query) !== false;
  }
  function search($query, $choices) {
    $matches = [];

    $d_query = strtolower($query);

    foreach($choices as $choice) {
      // Downcase both strings for case-insensitive search
      $d_choice = strtolower($choice);
      if(str_contains($d_choice, $d_query)) {
      // if(str_starts_with($d_choice, $d_query)) {
        $matches[] = $choice;
      }
    }

    return $matches;
  }
  echo "<h2>3. Create suggestions variable array. Print array.</h2>";
  $suggestions = search($query, $choices);
  echo '$suggestions = <br><br><pre>';
  print_r($suggestions);
  echo '</pre><br><br>$suggestions has type: ' . gettype($suggestions);

  // sort $suggestions
  echo "<h2>4. Sort suggestions variable array. Print array.</h2>";
  sort($suggestions);
  echo '<pre>';
  print_r($suggestions);
  echo '</pre>';

  // limit suggestions
  echo "<h2>5. Limit sorted suggestions variable array to a length of 5. Print array.</h2>";
  $max_suggestions = 5;
  $top_suggestions = array_slice($suggestions, 0, $max_suggestions);
  echo '<pre>';
  print_r($top_suggestions);
  echo '</pre>';

  // convert suggestions to a json parsable string
  echo "<h2>6. Encode 5 sorted suggestions variable string as a JSON parsable string. Echo string.</h2>";
  echo '<pre>';
  echo json_encode($top_suggestions);
  echo '</pre>';

  ?>

  <br /><br />
      <dl>
        <dt>Ajax Search</dt>
        <dd>
          <form id="search-form" action="search_train.php" method="GET">
            <?php $q = isset($_GET['q']) ? $_GET['q'] : ''; ?>
            <input id="search" type="text" name="q" value="<?php echo htmlspecialchars($q); ?>" />
            <input type="submit" value="Search" />
          </form>
        </dd>
      </dl>
      <ul id="suggestions">
      </ul>


    <h1>Create use</h1>
    <form action="<?php echo url_for('/staff/object_uses/new.php'); ?>" method="post">
      <dl>
        <dt>ObjectName</dt>
        <dd>
          <select name="ObjectName">
          <?php
            $type_set = find_all_objects();
            while($type = mysqli_fetch_assoc($type_set)) {
              echo "<option value=\"" . h($type['ID']) . "\"";
              echo ">" . h($type['ObjectName']) . "</option>";
            }
            mysqli_free_result($type_set);
          ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>UseDate</dt>
        <dd><input type="date" name="UseDate" value="<?php echo h($use['UseDate']); ?>" /></dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Create use" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>