<?php

/**
 * Database connection configuration
 *
 */
/**
 * config
 */
require_once './config.php';

require_once '../../include/config_variables.php';
require_once '../../include/functions_app_specific.php';
require_once '../../include/functions_generic.php';


//  Limit the maximum execution time
set_time_limit(123456);
$start_time = microtime(true);

echo "<pre>";
$show_query = TRUE;

/**
 * 
 * update query 
 * 
 * *****************************************************
 */

$sql = "SELECT
                id, 
                designation_code,
                designation
        FROM
                `total_manpower_imported_sanctioned_post_copy`
        GROUP BY
                designation_code
        ORDER BY
                org_code ";
$sp_result = mysql_query($sql) or die(mysql_error() . "<p>Code:getAllSanctionedPost:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");


/**
 * sanctioned_post_designation_group_code array
 */
$code = 'designation_code';
$value = 'group_code';
$table = 'sanctioned_post_designation';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$designation_group_code = array();

while ($data = mysql_fetch_assoc($r)) {
    $designation_group_code [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * sanctioned_post_designation_group_code array
 */
$code = 'designation_code';
$value = 'designation_group_name';
$table = 'sanctioned_post_designation';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$designation_group_name = array();

while ($data = mysql_fetch_assoc($r)) {
    $designation_group_name [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * sanctioned_post_designation_group_code array
 */
$code = 'designation_code';
$value = 'designation_discipline';
$table = 'sanctioned_post_designation';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$designation_discipline = array();

while ($data = mysql_fetch_assoc($r)) {
    $designation_discipline [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}



$row_count = 0;

while ($sp_data = mysql_fetch_assoc($sp_result)) {
    $row_count++;
    $query_string = "";
    $query_string .= "`group_code`=\"" . $designation_group_code[$sp_data['designation_code']] . "\",";
    $query_string .= "`designation_group_name`=\"" . $designation_group_name[$sp_data['designation_code']] . "\", ";
    $query_string .= "`discipline`=\"" . $designation_discipline[$sp_data['designation_code']] . "\" ";
    
    echo "\n\n\r------------------\n$row_count | "
    . $sp_data['designation_code'] . " | "
    . $sp_data['designation'] . " | "
    . "\n--- ";
    $sql = "UPDATE `total_manpower_imported_sanctioned_post_copy` SET "
            . " $query_string "
            . "WHERE (`designation_code`=\"" . $sp_data['designation_code'] . "\")";
    $result = mysql_query($sql) or die(mysql_error() . "<p>update_$value_field_name:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

    if ($show_query) {
        echo "\n\r | $sql";
    }
}

/**
 * 
 * 
 * END
 */
$time_end = microtime(true);

//dividing with 60 will give the execution time in minutes other wise seconds
$execution_time = ($time_end - $start_time);
//execution time of the script
echo "\n\n\n\r "
 . "------------------------------------------"
 . "\n\r\"Total Execution Time: $execution_time Second(s)\"";
