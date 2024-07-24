<?php

class Artifact extends DatabaseObject {

  static protected $table_name = 'games';
  static protected $db_columns = [
    'Access', 'Acq', 'Age', 'age_max', 'Av', 'BGG_Rat', 'Candidate', 'FavCt', 'FullTitle', 'id', 'KeptCol', 
    'KeptDig', 'KeptPhys', 'MnP', 'MnT', 'MxP', 'MxT', 'OrigPlat', 'SS', 'System', 'Title', 
    'type', 'UsedRecUserCt', 'user_id', 'Wt', 'Yr'
  ];

  public $id;

  public $Access;
  public $Acq;
  public $Age;
  public $age_max;
  public $Av;
  public $BGG_Rat;
  public $Candidate;
  public $FavCt;
  public $FullTitle;
  public $KeptCol;
  public $KeptDig;
  public $KeptPhys;
  public $MnP;
  public $MnT;
  public $MxP;
  public $MxT;
  public $OrigPlat;
  public $SS;
  public $System;
  public $Title;
  public $type;
  public $UsedRecUserCt;
  public $user_id;
  public $Wt;
  public $Yr;

  public static function list_games() {
    $sql = "SELECT ";
    $sql .= "games.id, ";
    $sql .= "games.Title ";
    $sql .= "FROM games ";
    $sql .= "ORDER BY games.Title ASC ";
    $sql .= "LIMIT 1000";

    $result = self::$database->query($sql);
    if ($result->num_rows > 0) {
      while($record = $result->fetch_assoc()) {
        $array[] = $record;
      }
    } else {
      $array = array();
    }
    return $array;
  }

  public static function list_games_by_query($query, $user_id) {
    $sql = 
      "SELECT 
        games.id, 
        games.Title 
      FROM games 
      WHERE games.Title LIKE '%" . self::$database->escape_string($query) . "%'
      AND user_id = '$user_id'
      ORDER BY games.Title ASC
    ";
    $result = self::$database->query($sql);
    if ($result->num_rows > 0) {
      while($record = $result->fetch_assoc()) {
        $array[] = $record;
      }
    } else {
      $array = array();
    }
    return $array;
  }

}

?>