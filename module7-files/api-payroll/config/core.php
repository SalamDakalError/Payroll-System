<?php
// core configuration
date_default_timezone_set('UTC');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// simple auth secret (extend as needed)
define('APP_SECRET', 'change_this_secret');

?>
