<?php

// users

// Performs all actions necessary to log in an admin
function log_in_user($user) {
// Renerating the ID protects the admin from session fixation.
  session_regenerate_id();
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['last_login'] = time();
  $_SESSION['username'] = $user['username'];
  $_SESSION['user_group'] = $user['user_group'];
  return true;
}

// admins

// Performs all actions necessary to log in an admin
function log_in_admin($admin) {
// Renerating the ID protects the admin from session fixation.
  session_regenerate_id();
  $_SESSION['admin_id'] = $admin['id'];
  $_SESSION['last_login'] = time();
  $_SESSION['username'] = $admin['username'];
  return true;
}

// Performs all actions necessary to log out an admin
function log_out() {
  unset($_SESSION['admin_id']);
  unset($_SESSION['user_id']);
  unset($_SESSION['last_login']);
  unset($_SESSION['username']);
  unset($_SESSION['user_group']);
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
