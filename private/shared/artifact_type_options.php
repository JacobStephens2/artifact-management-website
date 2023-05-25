<?php

  require_once 'artifact_type_array.php';
  global $typesArray;

  foreach ($typesArray as $typeCategory) {
    ?>
    <option 
      value="<?php echo $typeCategory; ?>" 
      <?php if ($type == $typeCategory ) { echo 'selected' ; } ?>
      >
      <?php echo $typeCategory; ?>
    </option>

    <?php
  }

?>