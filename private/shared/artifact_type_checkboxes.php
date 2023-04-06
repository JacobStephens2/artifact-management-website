<?php 
  if ($typeArray == 1) {
    $typeArray = ['nothing'];
  }
?>


<label>
    Game
</label>
<input
  type="checkbox"
  value="game" 
  name="type[game]"
  <?php if(in_array('game', $typeArray)) { echo 'checked' ; } ?>
>

<label>
    Board Game
</label>
<input
  type="checkbox"
  value="board-game" 
  name="type[board-game]"
  <?php if(in_array('board-game', $typeArray)) { echo 'checked' ; } ?>
>

<label>
    Card Game
</label>
<input
  type="checkbox"
  value="card-game" 
  name="type[card-game]"
  <?php if(in_array('card-game', $typeArray)) { echo 'checked' ; } ?>
>

<label>
    Video Game
</label>
<input
  type="checkbox"
  value="video-game" 
  name="type[video-game]"
  <?php if(in_array('video-game', $typeArray)) { echo 'checked' ; } ?>
>

<label>
    Children's Game
</label>
<input
  type="checkbox"
  value="childrens-game" 
  name="type[childrens-game]"
  <?php if(in_array('childrens-game', $typeArray)) { echo 'checked' ; } ?>
>

<label>
    Gambling Game
</label>
<input
  type="checkbox"
  value="gambling-game" 
  name="type[gambling-game]"
  <?php if(in_array('gambling-game', $typeArray)) { echo 'checked' ; } ?>
>

<label>
    Miniatures Game
</label>
<input
  type="checkbox"
  value="miniatures-game" 
  name="type[miniatures-game]"
  <?php if(in_array('miniatures-game', $typeArray)) { echo 'checked' ; } ?>
>

<label>
    Mobile Game
</label>
<input
  type="checkbox"
  value="mobile-game" 
  name="type[mobile-game]"
  <?php if(in_array('mobile-game', $typeArray)) { echo 'checked' ; } ?>
>

<label>
    Role Playing Game
</label>
<input
  type="checkbox"
  value="role-playing-game" 
  name="type[role-playing-game]"
  <?php if(in_array('role-playing-game', $typeArray)) { echo 'checked' ; } ?>
>

<label>
    Sport
</label>
<input
  type="checkbox"
  value="sport" 
  name="type[sport]"
  <?php if(in_array('sport', $typeArray)) { echo 'checked' ; } ?>
>

<label>
    Virtual Reality Game
</label>
<input
  type="checkbox"
  value="vr-game" 
  name="type[vr-game]"
  <?php if(in_array('vr-game', $typeArray)) { echo 'checked' ; } ?>
>

<label for="">
  Book
</label>
<input
  type="checkbox"
  value="book" 
  name="type[book]"
  <?php if(in_array('book', $typeArray)) { echo 'checked' ; } ?>
>

<label for="">
  Audiobook
</label>
<input
  type="checkbox"
  value="audiobook" 
  name="type[audiobook]"
  <?php if(in_array('audiobook', $typeArray)) { echo 'checked' ; } ?>
>

<label for="">
  Drink
</label>
<input
  type="checkbox"
  value="drink" 
  name="type[drink]"
  <?php if(in_array('drink', $typeArray)) { echo 'checked' ; } ?>
>

<label for="">
  Food
</label>
<input
  type="checkbox"
  value="food" 
  name="type[food]"
  <?php if(in_array('food', $typeArray)) { echo 'checked' ; } ?>
>

<label>
    Equipment
</label>
<input
  type="checkbox"
  value="equipment" 
  name="type[equipment]"
  <?php if(in_array('equipment', $typeArray)) { echo 'checked' ; } ?>
>

<label>
    Film
</label>
<input
  type="checkbox"
  value="film" 
  name="type[film]"
  <?php if(in_array('film', $typeArray)) { echo 'checked' ; } ?>
>

<label>
    Instrument
</label>
<input
  type="checkbox"
  value="instrument" 
  name="type[instrument]"
  <?php if(in_array('instrument', $typeArray)) { echo 'checked' ; } ?>
>

<label>
    Toy
</label>
<input
  type="checkbox"
  value="toy" 
  name="type[toy]"
  <?php if(in_array('toy', $typeArray)) { echo 'checked' ; } ?>
>

<label>
    Other
</label>
<input
  type="checkbox"
  value="other" 
  name="type[other]"
  <?php if(in_array('other', $typeArray)) { echo 'checked' ; } ?>
>
