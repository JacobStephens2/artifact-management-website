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

  <h1>Reading and transforming an array from the database</h1>

  <h2>1. Get results from database query. Print results.</h2>
  <?php  
    // run query
    $object_names = find_object_names();
    echo '$object_names has type: ' . gettype($object_names) . '<p>';
    echo '$object_names = ';
    print_r($object_names);
    echo '<p>';

    $choices = [];

    // this gets both ObjectName and ID from the query results, and places them into a multidimensional associative array, which is like a table. Each different array in the array represents a record with multiple fields. - in this case the two fields contained in each record are ObjectName and ID.
    $choices = mysqli_fetch_all($object_names, MYSQLI_ASSOC);
    
    // while($record = mysqli_fetch_assoc($object_names)) {
    //   // $choices [] = $record['ObjectName'];
    // }
    echo '$choices = <p><pre>';
    print_r($choices);
    echo '</pre><p>$choices has type: ' . gettype($choices);
    echo '</p>';
    echo 'JSON encoded representation of $choices: ' . '<p>';
    echo '<pre>' . json_encode($choices) . '</pre>';
    echo '<p/>';
    $object_in_array = $choices['9'];
    echo "\$choices['9'] - value in indexed position 9 in \$choices array: </p>";
    print_r($object_in_array);
    echo '</pre><p>$object_in_array has type: ' . gettype($object_in_array);

    $object9 = $object_in_array['ObjectName'];
    echo '<p> $object9 ($object_in_array["ObjectName"]) = </p>';
    print_r($object9);
    echo '<p>$object9 has type: ' . gettype($object9);

    echo '<p>Here is a reference directly to a string in the array from the two-dimensional array, $choices: </p>';
    echo '<p>' . $choices[0]['ObjectName'] . '</p>';
    echo '<p>This references data with the data type: ' . gettype($choices[0]['ObjectName']) . '</p>';

  ?>

  <h2>2. Create query variable string. Print string.</h2>
  <?php
    echo '$query = ';
    $query = 'Bib';
    print_r($query);
    echo '<p>$query has type: ' . gettype($query);
  ?>

  <h2>3. Create suggestions variable array / search for matches of search string in choices array. Print array.</h2>
  <?php
    function str_contains($choice, $query) {
      return strpos($choice, $query) !== false;
    }

    function search($query, $choices) {
      $matches = [];

      $d_query = strtolower($query);

      foreach($choices as $choice) {
        // Downcase both strings for case-insensitive search
        $d_choice = strtolower($choice);
        if(str_contains($choice, $d_query)) {
          $matches[] = $choice;
        }
      }
      return $matches;
    }

    $suggestions = search($query, $choices);

    echo '$suggestions = <pre>';
    print_r($suggestions);
    echo '</pre> $suggestions has type: ' . gettype($suggestions);
  ?>

  <h2>4. Sort suggestions variable array. Print array.</h2>
  <?php
    rsort($suggestions);
    echo '<pre>';
    print_r($suggestions);
    echo '</pre>';
  ?>

  <?php 
    $suggestion_length = 3; 
  ?>
  <h2>5. Limit sorted suggestions variable array to a length of <?php echo $suggestion_length; ?>. Print array.</h2>
  <?php
    $max_suggestions = $suggestion_length;
    $top_suggestions = array_slice($suggestions, 0, $max_suggestions);
    echo '$top_suggestions = ';
    echo '<pre>';
    print_r($top_suggestions);
    echo '</pre>';
    echo '$top_suggestions type = ' . gettype($top_suggestions);
  ?>

  <h2>6. Encode <?php echo $suggestion_length; ?> sorted suggestions variable string as a JSON parsable string. Echo string.</h2>
  <?php
    echo '$top_suggestions = ';
    echo '<pre>';
    echo json_encode($top_suggestions);
    echo '</pre>';
    echo '$top_suggestions type = ' . gettype($top_suggestions);

  ?>

  <br /><br />
      <dl>
        <dt>Ajax Search</dt>
        <dd>
          <form id="search-form" action="search.php" method="GET">
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