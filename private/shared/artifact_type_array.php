<?php   // define types array

  $result = query("SELECT DISTINCT(type) 
    FROM games
    ORDER BY type ASC
  ");

  foreach ($result as $row) {
    $typesArray[] = $row['type'];
  }

?>
