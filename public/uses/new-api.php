<?php
require_once('../../artifacts_private/initialize.php');
require_api_key();

header('Content-Type: application/json');

$bodyRaw = file_get_contents('php://input');
echo $bodyRaw;

