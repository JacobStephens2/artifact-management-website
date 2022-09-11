<?php

require ('../initialize.php');

$selectSQL = "SELECT * FROM players
WHERE FullName IS NULL";

$selectResult = $db->query($selectSQL);

echo "\n";
print_r($selectResult);
echo "\n";

foreach($selectResult as $row) {
  $updateSQL = "UPDATE players
    SET FullName = '" . $row['FirstName'] . " " . $row['LastName'] . "'
    WHERE id = " . $row['id']
  ;

  echo "\n";
  print_r($updateSQL);
  echo "\n";
  
  $updateResult = $db->query($updateSQL);

  echo "\n";
  print_r($updateResult);
  echo "\n";
  
}

?>