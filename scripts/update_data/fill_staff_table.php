<?php

/**
 * Database connection configuration
 *
 */
$dbhost = 'localhost';
$dbname = 'dghs_hrm_main';
$dbuser = 'root';
$dbpass = '';

mysql_select_db($dbname, mysql_connect($dbhost, $dbuser, $dbpass)) or die(mysql_error());
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");

require_once '../../include/config_variables.php';
require_once '../../include/functions_app_specific.php';
require_once '../../include/functions_generic.php';


//  Limit the maximum execution time
set_time_limit(123456);

/** ----------------------------------------------------------------------------
 *  
 * Function Call
 * 
 * -----------------------------------------------------------------------------
 */
echo "<pre>";

//$sql = "SELECT * FROM `old_tbl_staff_organization` limit 5";
//$sp_result = mysql_query($sql) or die(mysql_error() . "<p>Code:getAllSanctionedPost:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");
//
//$row_count = 0; 
//while ($sp_data = mysql_fetch_assoc($sp_result)){
//    $row_count++;
//    echo "<br /><br />------------------<br />$row_count | " 
//            . $sp_data['org_code'] . " | " 
//            . $sp_data['org_name'] . " | "
//            . $sp_data['id'] . ""
//            . "<br />--- ";
//    
//    // update org_name
//    $code_field_name = 'org_code';
//    $value_field_name = 'org_name';
//    $code = $sp_data[$code_field_name];    
//    $value = $org_location_data['org_name'];
//    $show_query = TRUE;
//    update_staff_data($code_field_name, $code, $value_field_name, $value, $show_query);
//}

/** * ***************************************************************************
 *  
 * Function definitions 
 * 
 * *****************************************************************************
 */

function update_staff_data ($code_field_name, $code, $value_field_name, $value, $show_query){
    if (!$code > 0){
        return FALSE;
    }
    $sql = "UPDATE `old_tbl_staff_organization` SET `$value_field_name`=\"$value\" WHERE (`$code_field_name`='$code')";
    $result = mysql_query($sql) or die(mysql_error() . "<p>update_$value_field_name:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

    if ($show_query) {
        echo "<br />$value_field_name | $sql";
    }
}