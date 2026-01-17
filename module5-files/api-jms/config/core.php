<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);


$home_urlJMS = "http://localhost/is301-bsis2x-initials/module5-files/api-initials"; 


$pageJMS = isset($_GET['page']) ? $_GET['page'] : 1; 


$records_per_pageJMS = 5; 


$from_record_numJMS = ($records_per_pageJMS * $pageJMS) - $records_per_pageJMS; 

// show error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// page given in URL parameter, default page is one
$pageJMS = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_pageJMS = 5;

// calculate for the query LIMIT clause
$from_record_numJMS = ($records_per_pageJMS * $pageJMS) - $records_per_pageJMS;

// home page url
$home_urlJMS = "http://localhost/sia101-bsit2a-jms/module5-files/api-jms/";

?>


