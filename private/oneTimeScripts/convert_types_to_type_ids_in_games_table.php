<?php

require ('../initialize.php');

$results = query(
    "SELECT id, title, type 
    FROM games
    WHERE user_id = 8
");

foreach ($results as $result) {
    print_r($result);
    $type = $result['type'];
    $artifact_id = $result['id'];
    $type_id = singleValueQuery(
        "SELECT id
        FROM types
        WHERE objectType = '$type'
    ");
    echo "$type type id $type_id \n";
    $result = query(
        "UPDATE games
        SET type_id = '$type_id'
        WHERE id = '$artifact_id'
        LIMIT 1
    ");
    var_dump($result);
}

?>