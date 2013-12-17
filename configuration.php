<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE );

session_start();


/**
 * Application basic configuration
 */
$app_name = "DGHS HRM Application";
$site_name = "DGHS HRM";
$copyright = "DGHS";

/**
 * Database connection configuration
 * 
 */

$dbhost='localhost';	
$dbname='dghs_hrm_main';	
$dbuser='root';
$dbpass='';

mysql_select_db($dbname,mysql_connect($dbhost, $dbuser, $dbpass))or die(mysql_errno());

$hrm_root_dir = "http://app.dghs.gov.bd/hrm";

require_once 'include/functions_app_specific.php';
require_once 'include/functions_generic.php';



?>
