<?php
/**
 * 
 * UPDATE `organization` table 
 * SET `upazila_id` = admin_upazila.id
 * 
 */

/**
 * config
 */
require_once './config.php';
$row_count = 0;
echo '<pre>';

/**
 * get all
 */

$sql = "SELECT
                organization.id,
                organization.district_code,
                organization.upazila_thana_code
        FROM
                `organization`";
$all_result = mysql_query($sql) or die(mysql_error() . "<p>Code:getAll:1\n\n<b>Query:</b>\n___\n$sql</p>");

while ($all_data = mysql_fetch_assoc($all_result)){
    $row_count++;
    
    $upazila_id = getUpazilaIdFromBBSCode($all_data['upazila_thana_code'], $all_data['district_code']);
    
    $sql = "UPDATE `organization` SET upazila_id = $upazila_id WHERE id = " . $all_data['id'];
    $r = mysql_query($sql) or die(mysql_error() . "<p>Code:getAll:3\n\n<b>Query:</b>\n___\n$sql</p>");
       
    echo "$row_count | $sql\n";
    
    if ($row_count ==3){
        break;
    }
}

/**
 * function
 */
function getUpazilaIdFromBBSCode($upazila_code, $district_code){
    $sql = "SELECT id FROM `admin_upazila` WHERE upazila_bbs_code = '$upazila_code' AND upazila_district_code = '$district_code';";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:getAll:2\n\n<b>Query:</b>\n___\n$sql</p>");       
    
    if (mysql_num_rows($result)){
        $data = mysql_fetch_assoc($result);
        return $data['id'];
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