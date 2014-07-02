<?php

/**
 * Database connection configuration
 *
 */
$dbhost = 'localhost';
$dbname = 'dghs_hrm_main';
$dbuser = 'root';
$dbpass = 'root';

mysql_select_db($dbname, mysql_connect($dbhost, $dbuser, $dbpass)) or die(mysql_error());
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");


//  Limit the maximum execution time
set_time_limit(18000);

$start_time = microtime(true);