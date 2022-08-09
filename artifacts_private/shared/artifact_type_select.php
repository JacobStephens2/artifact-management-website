<label for="type">Type</label>
<select name="type" id="type">

  <option 
    value="board-game" 
    <?php if($type=='board-game' ) { echo 'selected' ; } ?>
    >
    Board Game
  </option>
  
  <option 
    value="role-playing-game" 
    <?php if($type=='role-playing-game' ) { echo 'selected' ; } ?>
    >
    Role Playing Game
  </option>
  
  <option 
    value="video-game" 
    <?php if($type=='video-game' ) { echo 'selected' ; } ?>
    >
    Video Game
  </option>
  
  <option 
    value="sport" 
    <?php if($type=='sport' ) { echo 'selected' ; } ?>
    >
    Sport
  </option>
  
  <option 
    value="game" 
    <?php if($type=='game' ) { echo 'selected' ; } ?>
    >
    Game
  </option>
  
  <option 
    value="vr-game" 
    <?php if($type=='vr-game' ) { echo 'selected' ; } ?>
    >
    VR Game
  </option>
  
  <option 
    value="video" 
    <?php if($type=='video' ) { echo 'selected' ; } ?>
    >
    Video
  </option>
  
  <option 
    value="toy" 
    <?php if($type=='toy' ) { echo 'selected' ; } ?>
    >
    Toy
  </option>
  
  <option 
    value="mobile-game" 
    <?php if($type=='mobile-game' ) { echo 'selected' ; } ?>
    >
    Mobile Game
  </option>
  
  <option 
    value="equipment" 
    <?php if($type=='equipment' ) { echo 'selected' ; } ?>
    >
    Equipment
  </option>
  
  <option 
    value="other" 
    <?php if($type=='other' ) { echo 'selected' ; } ?>
    >
    Other
  </option>

</select>