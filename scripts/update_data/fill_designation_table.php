<?php

/**
 * Database connection configuration
 *
 */
/**
 * config
 */
require_once './config.php';

//  Limit the maximum execution time
set_time_limit(18000);


$start_time = microtime(true);
/** ----------------------------------------------------------------------------
 *  
 * Function Call
 * 
 * -----------------------------------------------------------------------------
 */
echo "<pre>";


$show_query = TRUE;

/**
 * 
 * 
 * 
 * update query 
 */
$sql = "SELECT * FROM `sanctioned_post_designation`";
$designation_result = mysql_query($sql) or die(mysql_error() . "<p>Code:getAll:1\n\n<b>Query:</b>\n___\n$sql</p>");

$row_count = 0;
while ($designation_data = mysql_fetch_assoc($designation_result)) {
    $designation = $designation_data['designation'];

    if (substr_count($designation, '(')) {
        $designation_parts = explode("(", $designation);
        
        $designation_name = trim($designation_parts[0]);
        $designation_discipline = trim(str_replace(")", "", $designation_parts[1]));
                
    } else {
        $designation_name = trim($designation);
        $designation_discipline = "";        
    }

    echo $designation . " || " . $designation_name . " | " . $designation_discipline;
    echo "\n";
    
    $sql = "UPDATE `sanctioned_post_designation`
            SET `designation_discipline` = '$designation_discipline',
             `designation_group_name` = '$designation_name'
            WHERE
                    (`id` = '" . $designation_data['id'] . "')";
    $r = mysql_query($sql) or die(mysql_error() . "<p>Code:getAll:1\n\n<b>Query:</b>\n___\n$sql</p>");
}

echo "\n\n\n populate designation group code in 'group_code' column\n\n";
//populate designation group code in 'group_code' column
$sql = "SELECT * FROM `sanctioned_post_designation` GROUP BY designation_group_name;";
$designation_result = mysql_query($sql) or die(mysql_error() . "<p>Code:getAll:1\n\n<b>Query:</b>\n___\n$sql</p>");

$designation_group_code_count = 100001;
while ($designation_data = mysql_fetch_assoc($designation_result)){
    
    $sql = "UPDATE `sanctioned_post_designation`"
            . " SET "
            . " `group_code` = '$designation_group_code_count' "
            . " WHERE "
            . " (`designation_group_name` LIKE '" . $designation_data['designation_group_name'] . "')";
    $r = mysql_query($sql) or die(mysql_error() . "<p>Code:getAll:1\n\n<b>Query:</b>\n___\n$sql</p>");
    
    echo "\n$sql";
    $designation_group_code_count++;
}