<?php

/**
 * Database connection configuration
 * 
 */

//local connection
$dbhost='localhost';	
$dbname='dghs_hrm_main';	
$dbuser='root';
$dbpass='';


// remote 
//$dbhost='localhost';	
//$dbname='stagedgh_dghs';	
//$dbuser='stagedgh_hrm';
//$dbpass='activation';

mysql_select_db($dbname,mysql_connect($dbhost, $dbuser, $dbpass))or die(mysql_errno());

?>
