<?php

  require_once 'artifact_type_array.php';
  global $typesArray;
  var_dump($type);

  foreach ($typesArray as $typeCategory) {
    ?>
    <option 
      value="<?php echo $typeCategory; ?>" 
      <?php
        if ($type === '' && $typeCategory === 'book') {
          echo 'selected';
        } elseif ($type == $typeCategory ) { 
          echo 'selected';
        } 
      ?>
      >
      <?php echo $typeCategory; ?>
    </option>

    <?php
  }

?>