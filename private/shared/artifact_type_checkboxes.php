<style>

  #artifactType label {
    margin-right: 1.2rem;
    display: inline;
  }

  #artifactType input {
    display: inline;
    height: 1.5rem;
    width: 1.5rem;
  }

</style>

<?php   

  $typesArray = [
    'game',
    'board-game',
    'card-game',
    'childrens-game',
    'gambling-game',
    'miniatures-game',
    'mobile-game',
    'role-playing-game',
    'sport',
    'vr-game',
    'book',
    'audiobook',
    'drink',
    'food',
    'equipment',
    'film',
    'instrument',
    'toy',
    'other'
  ];
  
?>
<button id="selectAll">Select All</button>
<button id="deselectAll">Deselect All</button>

<span id="typeCheckboxes">
  <?php
    foreach ($typesArray as $artifactType) {
      ?>
        <input
          type="checkbox"
          value="<?php echo $artifactType; ?>" 
          name="type[<?php echo $artifactType; ?>]"
          <?php 
            if(in_array($artifactType, $type)) { 
              echo 'checked'; 
            } elseif (count($type) === 0) {
              echo 'checked';
            }
          ?>
        >
        <label>
          <?php echo $artifactType; ?>
        </label>
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

