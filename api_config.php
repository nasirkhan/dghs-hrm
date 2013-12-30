<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE );

/**
 * Application basic configuration
 */
$app_name = "DGHS HRM Application";
$site_name = "DGHS HRM";
$copyright = "DGHS";


$dbhost='localhost';	
$dbname='dghs_hrm_main';	
$dbuser='root';
$dbpass='';


require_once 'include/functions_app_specific.php';
require_once 'include/functions_generic.php';

?>
