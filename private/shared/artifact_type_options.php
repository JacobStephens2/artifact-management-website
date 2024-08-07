<?php

  require_once 'artifact_type_array.php';
  global $typesArray;
  global $type_id;

  $match_found = false;
  foreach ($typesArray as $type => $id) {
    ?>
    <option 
      value="<?php echo $id; ?>" 
      <?php
        if ($id == $type_id) { 
          $match_found = true;
          echo ' selected ';
        } 
        if ($id == DEFAULT_TYPE && $match_found === false) {
          echo ' selected ';
        }
      ?>
      >
      <?php echo $type; ?>
    </option>

    <?php
  }

?>