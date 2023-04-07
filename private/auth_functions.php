<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Performs all actions necessary to log in an admin
function log_in_user($user) {
  // Renerating the ID protects the admin from session fixation.
  session_regenerate_id();

  global $db;
  if ($user['player_id'] == '') {
    $user['player_id'] = $user['id'];
  }
  $getPlayerSQL = "SELECT 
    *
    FROM players
    WHERE id = " . $user['player_id']
  ;
  echo $getPlayerSQL;
  $playerResultObject = mysqli_query($db, $getPlayerSQL);
  $playerArray = mysqli_fetch_assoc($playerResultObject);

  $_SESSION['FullName'] = $playerArray['FullName'];
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['player_id'] = $user['player_id'];
  $_SESSION['last_login'] = time();
  $_SESSION['username'] = $user['username'];
  $_SESSION['user_group'] = $user['user_group'];
  $_SESSION['logged_in'] = true;
  // Create JWT access token cookie for response 
  $issuedAt   = new DateTimeImmutable();
  $jwt_access_token_data = [
      // Issued at: time when the token was generated
      'iat'  => $issuedAt->getTimestamp(),  
      'iss'  => $_SERVER['SERVER_NAME'], // Issuer
      'nbf'  => $issuedAt->getTimestamp(), // Not before 
      'exp'  => $issuedAt->modify('+1440 minutes')->getTimestamp(), // Expire in 24 hours                    
      'user_id' => $user['id'],
  ];
  $access_token = JWT::encode(
      $jwt_access_token_data,
      JWT_SECRET,
      'HS256'
  );

  setcookie(
      "access_token",         // name
      $access_token,          // value
      time() + (86400 * 7),   // expire, 86400 = 1 day
      "",                     // path
      ARTIFACTS_DOMAIN,       // domain
      COOKIE_SECURE,         // if true, send cookie only to https requests
      true                    // httponly
  ); // End of JWT Access Token Cookie creation
  return true;
}

function authenticate() {
  $headers = apache_request_headers();
  $response = new stdClass;

  if (isset($_COOKIE["access_token"])) {
    try {
      $jwt = $_COOKIE["access_token"];
      $key  = JWT_SECRET;
      $decodedJWT = JWT::decode($jwt, new Key($key, 'HS256'));
      $decodedJWT->authenticated = true;
      return $decodedJWT;

    } catch (Exception $e) {
      $response->message = 'You have not been authenticated';
      $response->authenticated = false;
      return $response;
    }
  } else {
    if ($headers['Authorization'] == ARTIFACTS_API_KEY) {
      $response->message = 'Your API Key is valid.';
      $response->authenticated = true;
      return $response;
    } else {
      $response->message = 'You have not been authenticated';
      return $response;
    }
  }
}

// Performs all actions necessary to log out an admin
function log_out() {
  unset($_SESSION['admin_id']);
  unset($_SESSION['user_id']);
  unset($_SESSION['last_login']);
  unset($_SESSION['username']);
  unset($_SESSION['user_group']);
  unset($_SESSION['logged_in']);
  // session_destroy(); // optional: destroys the whole session
  return true;
}

function is_logged_in() {
  // Having a admin_id in the session serves a dual-purpose:
  // - Its presence indicates the admin is logged in.
  // - Its value tells which admin for looking up their record.
  return isset($_SESSION['admin_id']);
  }


// Requires the user logging in at least be in the user group or higher
function is_admin($user_group) {
  if(!$user_group = 2 ) {
    echo 1;
  } else {
    // Do nothing, let the rest of the page proceed
  }
}

// Requires the user logging in at least be in the user group or higher
function require_login() {
    if($_SESSION['user_group'] < 1 ) {
      redirect_to(url_for('/login.php'));
    } else {
      // Do nothing, let the rest of the page proceed
    }
}

function require_admin() {
  if($_SESSION['user_group'] < 2 ) {
    redirect_to(url_for('/login.php'));
  } else {
    // Do nothing, let the rest of the page proceed
  }
}



?>
