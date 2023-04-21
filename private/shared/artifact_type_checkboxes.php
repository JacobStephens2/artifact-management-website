<?php 
  if ($typeArray == 1) {
    $typeArray = ['nothing'];
  }
  $typesArray = [
    'game',
    'board-game',
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

  foreach ($typesArray as $type) {
    ?>
    <label>
        <?php echo $type; ?>
    </label>
    <input
      type="checkbox"
      value="<?php echo $type; ?>" 
      name="type[<?php echo $type; ?>]"
      <?php 
        if(in_array($type, $typeArray)) { 
          echo 'checked' ; 
        } 
      ?>
    >
    <?php
  }
?>
