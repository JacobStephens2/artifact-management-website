<?php

  require_once 'artifact_type_array.php';
  global $typesArray;
  var_dump($type);

  $match_found = false;
  foreach ($typesArray as $typeCategory) {
    ?>
    <option 
      value="<?php echo $typeCategory; ?>" 
      <?php
        if ($type == $typeCategory ) { 
          $match_found = true;
          echo 'selected';
        } 
        if ($typeCategory === 'other' && $match_found === false) {
          echo 'selected';
        }
      ?>
      >
      <?php echo $typeCategory; ?>
    </option>

    <?php
  }

?>