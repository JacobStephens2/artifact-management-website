<?php

  require_once('/var/www/artifact-management-tool/private/initialize.php');
  header('Content-Type: application/json');

  $userID = $_GET['userID'];

  $response = new stdClass;
  $response->userID = $userID;

  $response->count_to_notify_about = email_artifact_use_notice($userID);

  echo json_encode($response);

?>