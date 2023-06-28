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
  <button id="selectGames">Select Games</button>
</div>

<span id="typeCheckboxes" style="display: flex; flex-wrap: wrap">
  <?php
    foreach ($typesArray as $artifactType) {
      ?>
      <span>
        <input
          type="checkbox"
          id="<?php echo $artifactType; ?>" 
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
              echo str_replace('-', ' ', $artifactType); 
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
  
  document.querySelector('#selectGames').addEventListener('click', function(event) {
    event.preventDefault();
    document.querySelectorAll('#typeCheckboxes input').forEach(element => element.checked = false);
    document.querySelector('#typeCheckboxes #childrens-game').checked = true;
    document.querySelector('#typeCheckboxes #gambling-game').checked = true;
    document.querySelector('#typeCheckboxes #game').checked = true;
    document.querySelector('#typeCheckboxes #gambling-game').checked = true;
    document.querySelector('#typeCheckboxes #individual-display').checked = true;
    document.querySelector('#typeCheckboxes #mobile-game').checked = true;
    document.querySelector('#typeCheckboxes #role-playing-game').checked = true;
    document.querySelector('#typeCheckboxes #shared-display').checked = true;
    document.querySelector('#typeCheckboxes #sport').checked = true;
    document.querySelector('#typeCheckboxes #table-game').checked = true;
    document.querySelector('#typeCheckboxes #vr-game').checked = true;
  })
</script>

