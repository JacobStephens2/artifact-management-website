<?php

  require_once 'artifact_type_array.php';
  global $typesArray;
  global $type;

?>

<style>

  #typeCheckboxes label {
    margin-right: 1.2rem;
    display: inline;
  }

  #typeCheckboxes input {
    display: inline;
    height: 1.5rem;
    width: 1.5rem;
  }

  #typeCheckboxes span {
    white-space: nowrap;
  }

  #type #typeCheckboxes input[type="checkbox"] {
      margin-right: 0.3rem;
      margin-bottom: 1rem;
  }

</style>

<div id="selectButtons">
  <button id="selectAll">Select All</button>
  <button id="deselectAll"
    style="margin-left: 1rem"
    >
    Deselect All
  </button>
</div>

<span id="typeCheckboxes" style="display: flex; flex-wrap: wrap">
  <?php
    foreach ($typesArray as $artifactType) {
      ?>
      <span>
        <input
          type="checkbox"
          value="<?php echo $artifactType; ?>" 
          name="type[<?php echo $artifactType; ?>]"
          <?php 
            if(in_array($artifactType, $type)) { 
              echo 'checked'; 
            }
          ?>
        >
        <label>
          <?php 
            if ($artifactType === '') {
              echo 'no type';
            } else {
              // echo str_replace('-', ' ', $artifactType); 
              echo $artifactType; 
            }
          ?>
        </label>
      </span>
      <?php
    }
  ?>
</span>

<script>
  document.querySelector('#deselectAll').addEventListener('click', function(event) {
    event.preventDefault();
    document.querySelectorAll('#typeCheckboxes input').forEach(element => element.checked = false);
  })

  document.querySelector('#selectAll').addEventListener('click', function(event) {
    event.preventDefault();
    document.querySelectorAll('#typeCheckboxes input').forEach(element => element.checked = true);
  })
</script>

