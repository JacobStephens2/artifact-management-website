<?php   // define types array
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    $result = query(
      "SELECT id, ObjectType AS type
      FROM types
      WHERE user_id = '$user_id'
      ORDER BY type ASC
    ");

  } else {

    $result = query(
      "SELECT id, ObjectType AS type
      FROM types
      ORDER BY type ASC
    ");
    
  }

  foreach ($result as $row) {
    $typesArray[$row['type']] = $row['id'];
  }

?>
