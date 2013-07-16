<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE );

session_start();


/**
 * Application basic configuration
 */
$app_name = "DGHS HRM Application";
$site_name = "DGHS HRM";
$copyright = "DGHS";


require_once 'include/db_connection.php';
require_once 'include/functions_app_specific.php';
require_once 'include/functions_generic.php';



?>
