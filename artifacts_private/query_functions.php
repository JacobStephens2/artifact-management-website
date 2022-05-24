<!-- Contents
  // Object Uses
  // Types
  // Objects
  // Users
  // Admins
  // Games
  // Responses
  // Players
  // Playgroup
  // Explore
 -->

<?php
// Object Uses
  function delete_use($id) {
    global $db;

    $sql = "DELETE FROM use_table ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function find_all_uses() {
    global $db;

    $sql = "SELECT ";
    $sql .= "objects.ObjectName, ";
    $sql .= "use_table.UseDate, ";
    $sql .= "objects.user_id, ";
    $sql .= "use_table.ID ";
    $sql .= "FROM use_table ";
    $sql .= "LEFT JOIN objects ON objects.ID = use_table.ObjectName ";
    $sql .= "WHERE use_table.user_id = '" . db_escape($db, $_SESSION['user_id']) . "' ";
    $sql .= "ORDER BY UseDate DESC";

    // echo $sql . '<br>';
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  function find_use_by_id($id) {
    global $db;

    $sql = "SELECT ";
    $sql .= "objects.ObjectName, ";
    $sql .= "use_table.ObjectName AS objectID, ";
    $sql .= "use_table.UseDate, ";
    $sql .= "use_table.ID, ";
    $sql .= "types.ObjectType ";
    $sql .= "FROM use_table ";
    $sql .= "LEFT JOIN objects ON objects.ID = use_table.ObjectName ";
    $sql .= "LEFT JOIN types ON objects.ObjectType = types.ID ";
    $sql .= "WHERE use_table.id='" . db_escape($db, $id) . "' ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $subject = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $subject; // returns an assoc. array
  }
  function insert_use($use) {
    global $db;

    $errors = validate_use($use);
    if(!empty($errors)) {
      return $errors;
    }
    
/*
SELECT
objects.ObjectName,
use_table.UseDate,
objects.user_id,
use_table.ID
FROM use_table
LEFT JOIN objects ON objects.ID = use_table.ObjectName 
ORDER BY UseDate DESC
*/

    $sql = "INSERT INTO use_table ";
    $sql .= "(ObjectName, user_id, UseDate) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $use['ObjectName']) . "',";
    $sql .= "'" . db_escape($db, $_SESSION['user_id']) . "',";
    $sql .= "'" . db_escape($db, $use['UseDate']) . "'";
    $sql .= ")";

    echo $sql . "<br><br>";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function validate_use($use) {
    $errors = [];

    // UseDate

    return $errors;
  }

// Types
  function find_all_types() {
    global $db;

    $sql = "SELECT * FROM types";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  function find_type_by_id($id) {
    global $db;

    $sql = "SELECT * FROM types ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $type = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $type; // returns an assoc. array
  }

// Objects
  function use_objects_by_user($interval, $limit) {
    global $db;

    $sql = "SELECT ";
    $sql .=   "objects.ID, ";
    $sql .=   "objects.user_id, ";
    $sql .=   "objects.ObjectName, ";
    $sql .=   "types.ObjectType, ";
    $sql .=     "CASE ";
    $sql .=       "WHEN Max(use_table.UseDate) > objects.Acq THEN DATE_ADD(Max(use_table.UseDate), INTERVAL " . $interval * 2 . " DAY) ";
    $sql .=       "ELSE DATE_ADD(objects.Acq, INTERVAL " . $interval ." DAY) ";
    $sql .=     "END UseBy, ";
    $sql .=   "objects.KeptCol, ";
    $sql .=   "objects.Acq, ";
    $sql .=   "Max(use_table.UseDate) AS MaxUse ";
    $sql .= "FROM objects ";
    $sql .= "LEFT JOIN use_table ON objects.ID = use_table.ObjectName ";
    $sql .= "LEFT JOIN types ON objects.ObjectType = types.ID ";
    $sql .= "GROUP BY ";
    $sql .= "objects.ObjectName, ";
    $sql .= "objects.Acq, ";
    $sql .= "objects.KeptCol, ";
    $sql .= "objects.ID, ";
    $sql .= "types.ObjectType ";
    $sql .= "HAVING objects.KeptCol = 1 ";
    $sql .= "AND objects.user_id = '" . db_escape($db, $_SESSION['user_id']) . "' ";
    // $sql .= "AND types.ObjectType = 'book' ";
    $sql .= "ORDER BY UseBy ASC ";
    if ($limit == 1) {
      $sql .= "LIMIT 1";
    } else {
      $sql .= "LIMIT 1024";
    }

    // echo '<p>' . $sql . '</p>';
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  function find_object_names_by_user() {
    global $db;

    $sql = "SELECT ";
    // $sql .= "ID, ";
    $sql .= "ObjectName ";
    // $sql .= "* ";
    $sql .= "FROM objects ";
    $sql .= "WHERE user_id = '" . db_escape($db, $_SESSION['user_id']) . "'";
    // limit placed for easier dev, TODO remove when finished
    // $sql .= 'LIMIT 10';
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  function find_object_names() {
    global $db;

    $sql = "SELECT ";
    // $sql .= "ID, ";
    $sql .= "ObjectName ";
    // $sql .= "* ";
    $sql .= "FROM objects ";
    // limit placed for easier dev, TODO remove when finished
    // $sql .= 'LIMIT 10';
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  function list_objects_by_user() {
    global $db;

    $sql = "SELECT ";
    $sql .= "objects.ID, ";
    $sql .= "objects.ObjectName, ";
    $sql .= "objects.KeptCol, ";
    $sql .= "objects.Acq, ";
    $sql .= "types.ObjectType ";
    $sql .= "FROM objects ";
    $sql .= "LEFT JOIN types ON objects.ObjectType = types.ID ";
    $sql .= "WHERE user_id = '" . db_escape($db, $_SESSION['user_id']) . "' ";
    $sql .= "ORDER BY objects.ObjectName ASC";
    // echo '<p>' . $sql . '</p>';
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  function find_objects_by_user() {
    global $db;

    $sql = "SELECT ";
    $sql .= "objects.ID, ";
    $sql .= "objects.ObjectName, ";
    $sql .= "objects.KeptCol, ";
    $sql .= "objects.Acq, ";
    $sql .= "types.ObjectType ";
    $sql .= "FROM objects ";
    $sql .= "LEFT JOIN types ON objects.ObjectType = types.ID ";
    $sql .= "WHERE user_id = '" . db_escape($db, $_SESSION['user_id']) . "' ";
    $sql .= "ORDER BY objects.Acq DESC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  function find_all_objects() {
    global $db;

    $sql = "SELECT ";
    $sql .= "objects.ID, ";
    $sql .= "objects.ObjectName, ";
    $sql .= "objects.KeptCol, ";
    $sql .= "objects.Acq, ";
    $sql .= "types.ObjectType ";
    $sql .= "FROM objects ";
    $sql .= "LEFT JOIN types ON objects.ObjectType = types.ID ";
    $sql .= "ORDER BY objects.Acq DESC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  function find_object_by_id($id) {
    global $db;

    $sql = "SELECT ";
    // $sql .= "objects.ID, ";
    $sql .= "objects.ID, ";
    $sql .= "objects.ObjectName, ";
    $sql .= "objects.KeptCol, ";
    $sql .= "objects.Acq, ";
    $sql .= "types.ObjectType ";
    $sql .= "FROM objects ";
    $sql .= "LEFT JOIN types ON objects.ObjectType = types.ID ";
    $sql .= "WHERE objects.id='" . db_escape($db, $id) . "' ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $subject = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $subject; // returns an assoc. array
  }
  function update_object($object) {
    global $db;

    $errors = validate_object($object);
    if(!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE objects SET ";
    $sql .= "ObjectName='" . db_escape($db, $object['ObjectName']) . "', ";
    $sql .= "Acq='" . db_escape($db, $object['Acq']) . "', ";
    $sql .= "ObjectType='" . db_escape($db, $object['ObjectType']) . "', ";
    $sql .= "KeptCol='" . db_escape($db, $object['KeptCol']) . "' ";
    $sql .= "WHERE ID='" . db_escape($db, $object['ID']) . "' ";
    $sql .= "LIMIT 1;";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function validate_object($object) {
    $errors = [];

    // Title
    if(is_blank($object['ObjectName'])) {
      $errors[] = "Title cannot be blank.";
    } elseif(!has_length($object['ObjectName'], ['min' => 2, 'max' => 255])) {
      $errors[] = "Title must be between 2 and 255 characters.";
    }

    // KeptCol
    // Make sure we are working with a string
    $visible_str = (string) $object['KeptCol'];
    if(!has_inclusion_of($visible_str, ["0","1"])) {
      $errors[] = "Visible must be true or false.";
    }

    return $errors;
  }
  function insert_object_by_user($object) {
    global $db;

    $errors = validate_object($object);
    if(!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO objects ";
    // below did have 'user_id' in list after ObjectType
    $sql .= "(ObjectName, Acq, ObjectType, user_id, KeptCol) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $object['ObjectName']) . "',";
    $sql .= "'" . db_escape($db, $object['Acq']) . "',";
    $sql .= "'" . db_escape($db, $object['ObjectType']) . "',";
    $sql .= "'" . db_escape($db, $_SESSION['user_id']) . "',";
    $sql .= "'" . db_escape($db, $object['KeptCol']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function delete_object($id) {
    global $db;

    $sql = "DELETE FROM objects ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

// Users
  function find_user_by_username($username) {
    global $db;

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE username='" . db_escape($db, $username) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
  }
  function validate_user($user, $options=[]) {
    $errors = [];

    $password_required = $options['password_required'] ?? true;

    if(is_blank($user['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($user['first_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    }

    if(is_blank($user['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($user['last_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    }

    if(is_blank($user['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_length($user['email'], array('max' => 255))) {
      $errors[] = "Last name must be less than 255 characters.";
    } elseif (!has_valid_email_format($user['email'])) {
      $errors[] = "Email must be a valid format.";
    }

    if(is_blank($user['username'])) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($user['username'], array('min' => 8, 'max' => 255))) {
      $errors[] = "Username must be between 8 and 255 characters.";
    } elseif (!has_unique_username($user['username'], $user['id'] ?? 0)) {
      $errors[] = "Username not allowed. Try another.";
    }

    if($password_required) {
      if(is_blank($user['password'])) {
        $errors[] = "Password cannot be blank.";
      } elseif (!has_length($user['password'], array('min' => 12))) {
        $errors[] = "Password must contain 12 or more characters";
      } elseif (!preg_match('/[A-Z]/', $user['password'])) {
        $errors[] = "Password must contain at least 1 uppercase letter";
      } elseif (!preg_match('/[a-z]/', $user['password'])) {
        $errors[] = "Password must contain at least 1 lowercase letter";
      } elseif (!preg_match('/[0-9]/', $user['password'])) {
        $errors[] = "Password must contain at least 1 number";
      } elseif (!preg_match('/[^A-Za-z0-9\s]/', $user['password'])) {
        $errors[] = "Password must contain at least 1 symbol";
      }

      if(is_blank($user['confirm_password'])) {
        $errors[] = "Confirm password cannot be blank.";
      } elseif ($user['password'] !== $user['confirm_password']) {
        $errors[] = "Password and confirm password must match.";
      }
    }

    return $errors;
  }
  function reset_password($form_data) {
    global $db;

    $hashed_password = password_hash($form_data['password'], PASSWORD_BCRYPT);
    // $hashed_password = $new_password;

    $sql = "UPDATE users ";
    $sql .= "SET hashed_password = '" . db_escape($db, $hashed_password) . "' ";
    $sql .= "WHERE 'email' = '" . db_escape($db, $form_data['email']) . "'";
    $result = mysqli_query($db, $sql);
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function insert_user($user) {
    global $db;

    $errors = validate_user($user);
    if (!empty($errors)) {
      return $errors;
    }

    $hashed_password = password_hash($user['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users ";
    $sql .= "(first_name, last_name, email, username, hashed_password, user_group) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $user['first_name']) . "',";
    $sql .= "'" . db_escape($db, $user['last_name']) . "',";
    $sql .= "'" . db_escape($db, $user['email']) . "',";
    $sql .= "'" . db_escape($db, $user['username']) . "',";
    $sql .= "'" . db_escape($db, $hashed_password) . "',";
    $sql .= "'1'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    echo '<p>' . $sql . '</p>';
    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

// Admins
  function find_all_admins() {
    // Find all admins, ordered last_name, first_name
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "ORDER BY last_name ASC, first_name ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  function find_admin_by_id($id) {
    global $db;

    $sql = "SELECT * FROM admins ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $admin = mysqli_fetch_assoc($result); // find first
    mysqli_free_result($result);
    return $admin; // returns an assoc. array
  }
  function validate_admin($admin, $options=[]) {

    $password_required = $options['password_required'] ?? true;

    if(is_blank($admin['first_name'])) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($admin['first_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    }

    if(is_blank($admin['last_name'])) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($admin['last_name'], array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    }

    if(is_blank($admin['email'])) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_length($admin['email'], array('max' => 255))) {
      $errors[] = "Last name must be less than 255 characters.";
    } elseif (!has_valid_email_format($admin['email'])) {
      $errors[] = "Email must be a valid format.";
    }

    if(is_blank($admin['username'])) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($admin['username'], array('min' => 8, 'max' => 255))) {
      $errors[] = "Username must be between 8 and 255 characters.";
    } elseif (!has_unique_username($admin['username'], $admin['id'] ?? 0)) {
      $errors[] = "Username not allowed. Try another.";
    }

    if($password_required) {
      if(is_blank($admin['password'])) {
        $errors[] = "Password cannot be blank.";
      } elseif (!has_length($admin['password'], array('min' => 12))) {
        $errors[] = "Password must contain 12 or more characters";
      } elseif (!preg_match('/[A-Z]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 uppercase letter";
      } elseif (!preg_match('/[a-z]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 lowercase letter";
      } elseif (!preg_match('/[0-9]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 number";
      } elseif (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])) {
        $errors[] = "Password must contain at least 1 symbol";
      }

      if(is_blank($admin['confirm_password'])) {
        $errors[] = "Confirm password cannot be blank.";
      } elseif ($admin['password'] !== $admin['confirm_password']) {
        $errors[] = "Password and confirm password must match.";
      }
    }

    return $errors;
  }
  function insert_admin($admin) {
    global $db;

    $errors = validate_admin($admin);
    if (!empty($errors)) {
      return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO admins ";
    $sql .= "(first_name, last_name, email, username, hashed_password) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $admin['first_name']) . "',";
    $sql .= "'" . db_escape($db, $admin['last_name']) . "',";
    $sql .= "'" . db_escape($db, $admin['email']) . "',";
    $sql .= "'" . db_escape($db, $admin['username']) . "',";
    $sql .= "'" . db_escape($db, $hashed_password) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);

    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function update_admin($admin) {
    global $db;

    $password_sent = !is_blank($admin['password']);

    $errors = validate_admin($admin, ['password_required' => $password_sent]);
    if (!empty($errors)) {
      return $errors;
    }

    $hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

    $sql = "UPDATE admins SET ";
    $sql .= "first_name='" . db_escape($db, $admin['first_name']) . "', ";
    $sql .= "last_name='" . db_escape($db, $admin['last_name']) . "', ";
    $sql .= "email='" . db_escape($db, $admin['email']) . "', ";
    if($password_sent) {
      $sql .= "hashed_password='" . db_escape($db, $hashed_password) . "', ";
    }
    $sql .= "username='" . db_escape($db, $admin['username']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function delete_admin($admin) {
    global $db;

    $sql = "DELETE FROM admins ";
    $sql .= "WHERE id='" . db_escape($db, $admin['id']) . "' ";
    $sql .= "LIMIT 1;";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

// Games
  function find_games_by_user() {
    global $db;

    $sql = "SELECT ";
    $sql .= "games.id, ";
    $sql .= "games.Title, ";
    $sql .= "games.KeptCol, ";
    $sql .= "games.Acq, ";
    $sql .= "FROM games ";
    $sql .= "WHERE user_id = '" . db_escape($db, $_SESSION['user_id']) . "' ";
    $sql .= "ORDER BY objects.Acq DESC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  function find_all_board_games() {
    global $db;

    $sql = "SELECT * FROM games ";
    $sql .= "WHERE type = 'board-game' ";
    $sql .= "ORDER BY KeptCol DESC, Acq DESC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  function find_games_by_user_id($kept, $type) {
    global $db;

    $sql = "SELECT * FROM games ";
    $sql .= "WHERE user_id = '" . db_escape($db, $_SESSION['user_id']) . "' ";
    if($kept == 1) {
      $sql .= "AND KeptCol = 1 ";
    }
    if ($type != '1') {
      $sql .= "AND type = '" . $type . "' ";
    }
    $sql .= "ORDER BY KeptCol DESC, Acq DESC ";
    $sql .= "LIMIT 1024";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function find_game_by_id($id) {
    global $db;

    $sql = "SELECT * FROM games ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    // echo $sql;
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $subject = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $subject; // returns an assoc. array
  }
  function update_game($game) {
    global $db;

    $errors = validate_game($game);
    if(!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE games SET ";
    $sql .= "Title='" . db_escape($db, $game['Title']) . "', ";
    $sql .= "KeptCol='" . db_escape($db, $game['KeptCol']) . "', ";
    $sql .= "Acq='" . db_escape($db, $game['Acq']) . "', ";
    $sql .= "type='" . db_escape($db, $game['type']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $game['id']) . "' ";
    $sql .= "LIMIT 1";
    echo $sql . "<br /><br />";
    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function validate_game($game) {
    $errors = [];

    // Title
    if(is_blank($game['Title'])) {
      $errors[] = "Title cannot be blank.";
    } elseif(!has_length($game['Title'], ['min' => 2, 'max' => 255])) {
      $errors[] = "Title must be between 2 and 255 characters.";
    }

    // KeptCol
    // Make sure we are working with a string
    $visible_str = (string) $game['KeptCol'];
    if(!has_inclusion_of($visible_str, ["0","1"])) {
      $errors[] = "Kept must be true or false.";
    }

    return $errors;
  }
  function insert_game($object) {
    global $db;

    $errors = validate_game($object);
    if(!empty($errors)) {
      return $errors;
    }

    $sql = "INSERT INTO games ";
    $sql .= "(Title, Acq, type, KeptCol, user_id) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $object['Title']) . "',";
    $sql .= "'" . db_escape($db, $object['Acq']) . "',";
    $sql .= "'" . db_escape($db, $object['type']) . "',";
    $sql .= "'" . db_escape($db, $object['KeptCol']) . "',";
    $sql .= "'" . db_escape($db, $_SESSION['user_id']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function delete_game($id) {
    global $db;

    $sql = "DELETE FROM games ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function list_games() {
    global $db;

    $sql = "SELECT ";
    $sql .= "games.id, ";
    $sql .= "games.Title ";
    $sql .= "FROM games ";
    $sql .= "WHERE type = 'board-game' ";
    $sql .= "ORDER BY games.Title ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  function play_by($type, $interval) {
    global $db;

    $sql ="SELECT 
        games.Title,
        games.mnp,
        games.mxp,
        games.ss,
        games.id,
        games.type,
        games.user_id,
        CASE ";
    $sql .= "WHEN MAX(responses.PlayDate) < games.Acq THEN DATE_ADD(games.Acq, INTERVAL " . $interval . " DAY) ";
    $sql .= "WHEN MAX(responses.PlayDate) IS NULL THEN DATE_ADD(games.Acq, INTERVAL " . $interval . " DAY) ";
    $sql .= "ELSE DATE_ADD(MAX(responses.PlayDate), INTERVAL " .  $interval * 2 . " DAY)";
    $sql .= "END PlayBy,
        games.Acq,
        MAX(responses.PlayDate) AS MaxPlay,
        games.KeptCol
      FROM games
        LEFT JOIN responses ON games.id = responses.Title
      GROUP BY games.Acq,
        games.Title,
        games.KeptCol, games.mnp, games.mxp, games.ss, games.type, games.id ";
    $sql .= "HAVING games.user_id = " . db_escape($db, $_SESSION['user_id']) . " ";
    $sql .= "AND games.KeptCol = 1 ";
    if ($type != '1') {
      $sql .= "AND type = '" . $type . "' ";
    }
    $sql .= "ORDER BY PlayBy ASC";

    $result = mysqli_query($db, $sql);
      confirm_result_set($result);
      return $result;
  }

  function first_play_by() {
    global $db;

      $sql ="SELECT 
      games.Title,
      games.mnp,
      games.mxp,
      games.ss,
      games.type,
      CASE
          WHEN MAX(responses.PlayDate) < games.Acq THEN DATE_ADD(games.Acq, INTERVAL 180 DAY)
          WHEN MAX(responses.PlayDate) IS NULL THEN DATE_ADD(games.Acq, INTERVAL 180 DAY)
          ELSE DATE_ADD(MAX(responses.PlayDate), INTERVAL 360 DAY)
      END PlayBy,
      games.Acq,
      MAX(responses.PlayDate) AS MaxPlay,
      games.KeptCol
    FROM games
      LEFT JOIN responses ON games.id = responses.Title
    GROUP BY games.Acq,
      games.Title,
      games.KeptCol, games.mnp, games.mxp, games.ss, games.type

    HAVING (games.KeptCol) = 1
    and games.type = 'board-game'
    ORDER BY PlayBy ASC
    LIMIT 1";

    $result = mysqli_query($db, $sql);
      confirm_result_set($result);
      return $result;
  }


// Responses
  function validate_response($use) {
    $errors = [];

    return $errors;
  }
  function insert_response($response) {
    global $db;

    $errors = validate_response($response);
    if(!empty($errors)) {
      return $errors;
    }
    
    if ($response['PlayerCount'] >= 1) {
      $sql = "INSERT INTO responses ";
      $sql .= "(Title, PlayDate, Player, user_id) ";
      $sql .= "VALUES (";
      $sql .= "'" . db_escape($db, $response['Title']) . "', ";
      $sql .= "'" . db_escape($db, $response['PlayDate']) . "', ";
      $sql .= "'" . db_escape($db, $response['Player1']) . "', ";
      $sql .= "'" . db_escape($db, $_SESSION['user_id']) . "'";
      $sql .= ")";
      $result = mysqli_query($db, $sql);
    }
    if ($response['PlayerCount'] >= 2) {
      $sql = "INSERT INTO responses ";
      $sql .= "(Title, PlayDate, Player, user_id) ";
      $sql .= "VALUES (";
      $sql .= "'" . db_escape($db, $response['Title']) . "', ";
      $sql .= "'" . db_escape($db, $response['PlayDate']) . "', ";
      $sql .= "'" . db_escape($db, $response['Player2']) . "', ";
      $sql .= "'" . db_escape($db, $_SESSION['user_id']) . "'";
      $sql .= ")";
      $result = mysqli_query($db, $sql);
    }
    if ($response['PlayerCount'] >= 3) {
      $sql = "INSERT INTO responses ";
      $sql .= "(Title, PlayDate, Player, user_id) ";
      $sql .= "VALUES (";
      $sql .= "'" . db_escape($db, $response['Title']) . "', ";
      $sql .= "'" . db_escape($db, $response['PlayDate']) . "', ";
      $sql .= "'" . db_escape($db, $response['Player3']) . "', ";
      $sql .= "'" . db_escape($db, $_SESSION['user_id']) . "'";
      $sql .= ")";
      $result = mysqli_query($db, $sql);
    }
    if ($response['PlayerCount'] >= 4) {
      $sql = "INSERT INTO responses ";
      $sql .= "(Title, PlayDate, Player, user_id) ";
      $sql .= "VALUES (";
      $sql .= "'" . db_escape($db, $response['Title']) . "', ";
      $sql .= "'" . db_escape($db, $response['PlayDate']) . "', ";
      $sql .= "'" . db_escape($db, $response['Player4']) . "', ";
      $sql .= "'" . db_escape($db, $_SESSION['user_id']) . "'";
      $sql .= ")";
      $result = mysqli_query($db, $sql);
    }
    if ($response['PlayerCount'] >= 5) {
      $sql = "INSERT INTO responses ";
      $sql .= "(Title, PlayDate, Player, user_id) ";
      $sql .= "VALUES (";
      $sql .= "'" . db_escape($db, $response['Title']) . "', ";
      $sql .= "'" . db_escape($db, $response['PlayDate']) . "', ";
      $sql .= "'" . db_escape($db, $response['Player5']) . "', ";
      $sql .= "'" . db_escape($db, $_SESSION['user_id']) . "'";
      $sql .= ")";
      $result = mysqli_query($db, $sql);
    }
    if ($response['PlayerCount'] >= 6) {
      $sql = "INSERT INTO responses ";
      $sql .= "(Title, PlayDate, Player, user_id) ";
      $sql .= "VALUES (";
      $sql .= "'" . db_escape($db, $response['Title']) . "', ";
      $sql .= "'" . db_escape($db, $response['PlayDate']) . "', ";
      $sql .= "'" . db_escape($db, $response['Player6']) . "', ";
      $sql .= "'" . db_escape($db, $_SESSION['user_id']) . "'";
      $sql .= ")";
      $result = mysqli_query($db, $sql);
    }
    if ($response['PlayerCount'] >= 7) {
      $sql = "INSERT INTO responses ";
      $sql .= "(Title, PlayDate, Player, user_id) ";
      $sql .= "VALUES (";
      $sql .= "'" . db_escape($db, $response['Title']) . "', ";
      $sql .= "'" . db_escape($db, $response['PlayDate']) . "', ";
      $sql .= "'" . db_escape($db, $response['Player7']) . "', ";
      $sql .= "'" . db_escape($db, $_SESSION['user_id']) . "'";
      $sql .= ")";
      $result = mysqli_query($db, $sql);
    }
    if ($response['PlayerCount'] >= 8) {
      $sql = "INSERT INTO responses ";
      $sql .= "(Title, PlayDate, Player, user_id) ";
      $sql .= "VALUES (";
      $sql .= "'" . db_escape($db, $response['Title']) . "', ";
      $sql .= "'" . db_escape($db, $response['PlayDate']) . "', ";
      $sql .= "'" . db_escape($db, $response['Player8']) . "', ";
       $sql .= "'" . db_escape($db, $_SESSION['user_id']) . "'";
     $sql .= ")";
      $result = mysqli_query($db, $sql);
    }
    if ($response['PlayerCount'] >= 9) {
      $sql = "INSERT INTO responses ";
      $sql .= "(Title, PlayDate, Player, user_id) ";
      $sql .= "VALUES (";
      $sql .= "'" . db_escape($db, $response['Title']) . "', ";
      $sql .= "'" . db_escape($db, $response['PlayDate']) . "', ";
      $sql .= "'" . db_escape($db, $response['Player9']) . "', ";
      $sql .= "'" . db_escape($db, $_SESSION['user_id']) . "'";
      $sql .= ")";
      $result = mysqli_query($db, $sql);
    }
    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }  
  }
  function find_all_responses() {
    global $db;

    $sql = "SELECT ";
    $sql .= "games.Title, ";
    $sql .= "responses.id, ";
    $sql .= "players.FirstName, ";
    $sql .= "players.LastName, ";
    $sql .= "responses.PlayDate ";
    $sql .= "FROM responses ";
    $sql .= "LEFT JOIN games ON responses.Title = games.id ";
    $sql .= "LEFT JOIN players ON responses.Player = players.id ";
    $sql .= "ORDER BY responses.PlayDate DESC, ";
    $sql .= "games.Title DESC, ";
    $sql .= "players.LastName ASC, ";
    $sql .= "players.FirstName ASC ";
    $sql .= "LIMIT 100";

    // echo $sql . '<br>';
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  function find_responses_by_user_id() {
    global $db;

    $sql = "SELECT ";
    $sql .= "games.Title, ";
    $sql .= "responses.id, ";
    $sql .= "players.FirstName, ";
    $sql .= "players.LastName, ";
    $sql .= "responses.PlayDate ";
    $sql .= "FROM responses ";
    $sql .= "LEFT JOIN games ON responses.Title = games.id ";
    $sql .= "LEFT JOIN players ON responses.Player = players.id ";
    $sql .= "WHERE responses.user_id = " . db_escape($db, $_SESSION['user_id']) . " ";
    $sql .= "ORDER BY responses.PlayDate DESC, ";
    $sql .= "games.Title DESC, ";
    $sql .= "players.LastName ASC, ";
    $sql .= "players.FirstName ASC ";
    $sql .= "LIMIT 4000";

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  function find_response_by_id($id) {
    global $db;

    $sql = "SELECT ";
    $sql .= "games.Title, ";
    $sql .= "games.id AS gameid, ";
    $sql .= "responses.PlayDate, ";
    $sql .= "responses.Player, ";
    $sql .= "players.FirstName, ";
    $sql .= "players.LastName, ";
    $sql .= "responses.Title AS responsetitle, ";
    $sql .= "responses.id ";
    $sql .= "FROM responses ";
    $sql .= "LEFT JOIN players ON responses.Player = players.id ";
    $sql .= "LEFT JOIN games ON responses.Title = games.id ";
    $sql .= "WHERE responses.id='" . db_escape($db, $id) . "' ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $subject = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $subject; // returns an assoc. array
  }
  function update_response($object) {
    global $db;

    $errors = validate_response($object);
    if(!empty($errors)) {
      return $errors;
    }

    $sql = "UPDATE responses SET ";
    $sql .= "Title='" . db_escape($db, $object['Title']) . "', ";
    $sql .= "PlayDate='" . db_escape($db, $object['PlayDate']) . "', ";
    $sql .= "Player='" . db_escape($db, $object['Player']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $object['id']) . "' ";
    $sql .= "LIMIT 1;";

    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function delete_response($id) {
    global $db;

    $sql = "DELETE FROM responses ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

// Players
  function list_players() {
    global $db;

    $sql = "SELECT ";
    $sql .= "id, ";
    $sql .= "FirstName, ";
    $sql .= "LastName ";
    $sql .= "FROM players ";
    $sql .= "WHERE user_id='" . db_escape($db, $_SESSION['user_id']) . "' ";
    $sql .= "ORDER BY LastName ASC, ";
    $sql .= "FirstName ASC";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function find_player_by_id($id) {
    global $db;

    $sql = "SELECT *";
    $sql .= "FROM players ";
    $sql .= "WHERE players.id='" . db_escape($db, $id) . "' ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $subject = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $subject; // returns an assoc. array
  }

  function find_players_by_user_id() {
    global $db;

    $sql = "SELECT * FROM players ";
    $sql .= "WHERE user_id='" . db_escape($db, $_SESSION['user_id']) . "' ";
    $sql .= "ORDER BY id";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }
  function insert_player($player) {
    global $db;

    $sql = "INSERT INTO players ";
    $sql .= "(FirstName, LastName, G, Age, user_id) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $player['FirstName']) . "',";
    $sql .= "'" . db_escape($db, $player['LastName']) . "',";
    $sql .= "'" . db_escape($db, $player['G']) . "',";
    $sql .= "'" . db_escape($db, $player['Age']) . "',";
    $sql .= "'" . db_escape($db, $_SESSION['user_id']) . "'";
    $sql .= ")";
    $result = mysqli_query($db, $sql);
    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function update_player($player) {
    global $db;


    $sql = "UPDATE players SET ";
    $sql .= "FirstName='" . db_escape($db, $player['FirstName']) . "', ";
    $sql .= "LastName='" . db_escape($db, $player['LastName']) . "', ";
    $sql .= "G='" . db_escape($db, $player['G']) . "', ";
    $sql .= "Age='" . db_escape($db, $player['Age']) . "' ";
    $sql .= "WHERE id='" . db_escape($db, $player['id']) . "' ";
    $sql .= "LIMIT 1";
    echo $sql . "<br /><br />";
    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }
  function delete_player($id) {
    global $db;

    $sql = "DELETE FROM players ";
    $sql .= "WHERE id='" . db_escape($db, $id) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

// Playgroup

function count_playgroup() {
global $db;
$sql = "SELECT count(*) FROM playgroup";
$result = mysqli_query($db, $sql);
confirm_result_set($result);
$subject = mysqli_fetch_assoc($result);
mysqli_free_result($result);
return $subject; // returns an assoc. array
}

function choose_games_for_group($range, $type) {
  global $db;
  $playgroup_count = count_playgroup();

  $sql ="SELECT
  games.title,
  games.id,
  games.ss,
  games.MnP,
  games.MxP,
  games.MxT,
  games.Age,
  games.type,
  games.KeptCol,
  playgroup.FullName,
  players.FirstName,
  players.LastName,
  players.G,
  players.Priority,
  Max(responses.AversionDate) AS MaxOfAversionDate,
  Max(responses.PlayDate) AS MaxOfPlayDate,
  Max(responses.PassDate) AS MaxOfPassDate,
  Max(responses.RequestDate) AS MaxOfRequestDate
FROM (
      players
      LEFT JOIN (
          games
          LEFT JOIN responses ON games.ID = responses.Title
      ) ON players.ID = responses.Player
  )
  INNER JOIN playgroup ON players.ID = playgroup.FullName
GROUP BY 
  games.Title,
  games.MnP,
  games.Age,
  games.MxP,
  games.id,
  games.type,
  games.user_id,
  players.FirstName,
  players.LastName,
  playgroup.FullName,
  games.FavCt,
  players.G,
  players.Priority 
HAVING
keptcol = 1 ";
$sql .= "AND games.user_id = " . db_escape($db, $_SESSION['user_id']) . " ";
if ($range == 'true') {
  $sql .= "AND games.mnp <= " . $playgroup_count['count(*)'] . " ";
  $sql .= "AND games.mxp >= " . $playgroup_count['count(*)'] . " ";
} else {
  $sql .= "AND games.ss = " . $playgroup_count['count(*)'] . " ";
}
if ($type != '1') {
  $sql .= "AND games.type = '" . $type . "' ";
}
$sql .= "ORDER BY 
  players.G,
  players.Priority DESC,
  Max(responses.AversionDate) ASC,
  Max(responses.PlayDate) DESC,
  Max(responses.PassDate) ASC,
  Max(responses.RequestDate) DESC";

  $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

function update_playgroup_player($playgroupplayer) {
    global $db;

    $sql = "UPDATE playgroup SET ";
    $sql .= "FullName='" . db_escape($db, $playgroupplayer['FullName']) . "' ";
    $sql .= "WHERE ID='" . db_escape($db, $playgroupplayer['ID']) . "' ";
    $sql .= "LIMIT 1";
    echo $sql . "<br /><br />";
    $result = mysqli_query($db, $sql);
    // For UPDATE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // UPDATE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function delete_playgroup_player($ID) {
    global $db;

    $sql = "DELETE FROM playgroup ";
    $sql .= "WHERE ID='" . db_escape($db, $ID) . "'";
    $result = mysqli_query($db, $sql);

    // For DELETE statements, $result is true/false
    if($result) {
      return true;
    } else {
      // DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function find_playgroup_by_user_id() {
    global $db;

    $sql = "SELECT playgroup.ID, playgroup.FullName, players.FirstName, players.LastName, players.id AS playerID ";
    $sql .= "FROM playgroup LEFT JOIN players ON playgroup.FullName = players.id ";
    $sql .= "WHERE playgroup.user_id = '" . db_escape($db, $_SESSION['user_id']) . "'";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result; // returns an assoc. array
  }

  function find_playgroup_player_by_id($ID) {
    global $db;

    $sql = "SELECT playgroup.ID, playgroup.FullName, players.FirstName, players.LastName FROM playgroup LEFT JOIN players ON playgroup.FullName = players.id ";
    $sql .= "WHERE playgroup.ID='" . db_escape($db, $ID) . "' ";
    $sql .= "LIMIT 1";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $subject = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $subject; // returns an assoc. array
  }

  function insert_playgroup($response) {
    global $db;
    
    $playerCount = $response['playerCount'];
    $i = 1;
    while($playerCount >= $i) {
      $sql = "INSERT INTO playgroup ";
      $sql .= "(FullName, user_id) ";
      $sql .= "VALUES (";
      $sql .= "'" . db_escape($db, $response['Player' . $i]) . "', ";
      $sql .= "'" . db_escape($db, $_SESSION['user_id']) . "'";
      $sql .= ")";
      $result = mysqli_query($db, $sql);
      $i++;
    }
    // For INSERT statements, $result is true/false
    if($result) {
      return true;
    } else {
      // INSERT failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
  }  

}
// Explore
function find_games_by_characteristic($kept, $type, $allGames, $favCt) {
  global $db;

  $sql = "SELECT Title, id, mxt, mnt, ss, yr, wt, mnp, mxp, av, favct, age, bgg_rat, KeptCol, type ";
  $sql .= "FROM games ";
  $sql .= "WHERE ";

  if ($allGames == 'true') {
    $sql .= "user_id = " . db_escape($db, $_SESSION['user_id']) . " OR user_id = 8 ";
  } else {
    $sql .= "user_id = " . db_escape($db, $_SESSION['user_id']) . " ";
  } 
  
  $sql .= "AND ";
  
  if ($kept == 'true') {
    $sql .= "KeptCol = 1 ";
  } else {
    $sql .= '1 = 1 ';
  }

  $sql .= "AND ";

  if ($type != '1') {
    $sql .= "type = '" . $type . "' ";
  } else {
    $sql .= "1 = 1 ";
  }

  $sql .= "AND type IS NOT NULL ";
  $sql .= "AND type <> '' ";
  $sql .= "AND ss <> '' ";

  $sql .= "ORDER BY ";
  if ($favCt != '') {
    $sql .= "favct DESC, ";
    $sql .= "ss ASC, ";
    $sql .= "mxt ASC, ";
    $sql .= "mnt ASC, ";
    $sql .= "age ASC, ";
    $sql .= "bgg_rat DESC ";
  } else {
    $sql .= "ss ASC, ";
    $sql .= "mxt ASC, ";
    $sql .= "mnt ASC, ";
    $sql .= "age ASC, ";
    $sql .= "favct DESC, ";
    $sql .= "bgg_rat DESC ";
  }

  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

?>
