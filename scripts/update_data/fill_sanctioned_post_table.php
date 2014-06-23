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

require_once '../../include/config_variables.php';
require_once '../../include/functions_app_specific.php';
require_once '../../include/functions_generic.php';


//  Limit the maximum execution time
set_time_limit(123456);
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
 * sanctioned_post_designation array
 */
$code = 'designation_code';
$value = 'designation';
$table = 'sanctioned_post_designation';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$designation = array();

while ($data = mysql_fetch_assoc($r)) {
    $designation [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * sanctioned_post_designation_group_code array
 */
$code = 'designation_code';
$value = 'designation_group_code';
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
$value = 'ranking';
$table = 'sanctioned_post_designation';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$designation_ranking = array();

while ($data = mysql_fetch_assoc($r)) {
    $designation_ranking [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * type_of_post array
 */
$code = 'type_of_post_code';
$value = 'type_of_post_name';
$table = 'sanctioned_post_type_of_post';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$type_of_post = array();

while ($data = mysql_fetch_assoc($r)) {
    $type_of_post [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * class array
 */
$code = 'designation_code';
$value = 'class';
$table = 'sanctioned_post_designation';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$class = array();

while ($data = mysql_fetch_assoc($r)) {
    $class [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * payscale array
 */
$code = 'designation_code';
$value = 'payscale';
$table = 'sanctioned_post_designation';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$payscale = array();

while ($data = mysql_fetch_assoc($r)) {
    $payscale [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}


/**
 * bangladesh_professional_category_name array
 */
$code = 'bangladesh_professional_category_code';
$value = 'bangladesh_professional_category_name';
$table = 'sanctioned_post_bangladesh_professional_category';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$bangladesh_professional_category_name = array();

while ($data = mysql_fetch_assoc($r)) {
    $bangladesh_professional_category_name [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * who_occupation_group_name array
 */
$code = 'who_health_professional_group_code';
$value = 'who_health_professional_group_name';
$table = 'sanctioned_post_who_health_professional_group';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$who_occupation_group_name = array();

while ($data = mysql_fetch_assoc($r)) {
    $who_occupation_group_name [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}
/**
 * first_level_name array
 */
$code = 'id';
$value = 'first_level_name';
$table = 'sanctioned_post_first_level';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$first_level_name = array();

while ($data = mysql_fetch_assoc($r)) {
    $first_level_name [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}
$first_level_name['0'] = "";
/**
 * first_level_code array
 */
$code = 'id';
$value = 'first_level_code';
$table = 'sanctioned_post_first_level';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$first_level_code = array();

while ($data = mysql_fetch_assoc($r)) {
    $first_level_code [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}
$first_level_code['0'] = "0";

/**
 * second_level_name array
 */
$code = 'id';
$value = 'second_level_name';
$table = 'sanctioned_post_second_level';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$second_level_name = array();

while ($data = mysql_fetch_assoc($r)) {
    $second_level_name [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}
$second_level_name['0'] = "";

/**
 * second_level_code array
 */
$code = 'id';
$value = 'second_level_code';
$table = 'sanctioned_post_second_level';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$second_level_code = array();

while ($data = mysql_fetch_assoc($r)) {
    $second_level_code [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}
$second_level_code['0'] = "0";



$sql = "SELECT * FROM `total_manpower_imported_sanctioned_post_copy` ORDER BY id limit 500";
$sp_result = mysql_query($sql) or die(mysql_error() . "<p>Code:getAllSanctionedPost:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$row_count = 0;
while ($sp_data = mysql_fetch_assoc($sp_result)) {
    $row_count++;
   
    // get org loaction data of this sanctioned post
    $org_location_data = getOrgInfoOfSanctionedPost($sp_data['org_code']);

    $query_string = "";

    // update org_name
    $code_field_name = 'org_code';
    $value_field_name = 'org_name';
    $code = $sp_data[$code_field_name];
    $value = $org_location_data['org_name'];
    $query_string .= "`$value_field_name`=\"" . $value . "\",";

    // update org_type_name
    $code_field_name = 'org_code';
    $value_field_name = 'org_type_name';
    $code = $sp_data[$code_field_name];
    $value = $org_location_data['org_type_name'];
    $query_string .= "`$value_field_name`=\"" . $value . "\",";

    // update org_type_code
    $code_field_name = 'org_code';
    $value_field_name = 'org_type_code';
    $code = $sp_data[$code_field_name];
    $value = $org_location_data['org_type_code'];
    $query_string .= "`$value_field_name`=\"" . $value . "\",";

    // update division_name
    $code_field_name = 'org_code';
    $value_field_name = 'division_name';
    $code = $sp_data[$code_field_name];
    $value = $org_location_data['division_name'];
    $query_string .= "`$value_field_name`=\"" . $value . "\",";

    // update division_code
    $code_field_name = 'org_code';
    $value_field_name = 'division_code';
    $code = $sp_data[$code_field_name];
    $value = $org_location_data['division_code'];
    $query_string .= "`$value_field_name`=\"" . $value . "\",";


    // update district_name
    $code_field_name = 'org_code';
    $value_field_name = 'district_name';
    $code = $sp_data[$code_field_name];
    $value = $org_location_data['district_name'];
    $query_string .= "`$value_field_name`=\"" . $value . "\",";


    // update district_code
    $code_field_name = 'org_code';
    $value_field_name = 'district_code';
    $code = $sp_data[$code_field_name];
    $value = $org_location_data['district_code'];
    $query_string .= "`$value_field_name`=\"" . $value . "\",";


    // update upazila_thana_name
    $code_field_name = 'org_code';
    $value_field_name = 'upazila_name';
    $code = $sp_data[$code_field_name];
    $value = $org_location_data['upazila_thana_name'];
    $query_string .= "`$value_field_name`=\"" . $value . "\",";

    // update upazila_thana_code
    $code_field_name = 'org_code';
    $value_field_name = 'upazila_code';
    $code = $sp_data[$code_field_name];
    $value = $org_location_data['upazila_thana_code'];
    $query_string .= "`$value_field_name`=\"" . $value . "\",";


    $query_string .= "`designation`=\"" . $designation[$sp_data['designation_code']] . "\",";
    $query_string .= "`designation_group_code`=\"" . $designation_group_code[$sp_data['designation_code']] . "\",";
    $query_string .= "`designation_group_name`=\"" . $designation_group_name[$sp_data['designation_code']] . "\",";
    $query_string .= "`bangladesh_professional_category_name`=\"" . $bangladesh_professional_category_name[$sp_data['bangladesh_professional_category_code']] . "\",";
    $query_string .= "`who_occupation_group_name`=\"" . $who_occupation_group_name[$sp_data['who_occupation_group_code']] . "\",";
    $query_string .= "`first_level_name`=\"" . $first_level_name[$sp_data['first_level_id']] . "\",";
    $query_string .= "`first_level_code`=\"" . $first_level_code[$sp_data['first_level_id']] . "\",";
    $query_string .= "`second_level_name`=\"" . $second_level_name[$sp_data['second_level_id']] . "\",";
    $query_string .= "`second_level_code`=\"" . $second_level_code[$sp_data['second_level_id']] . "\", ";
    $query_string .= "`type_of_post_name`=\"" . $type_of_post[$sp_data['type_of_post']] . "\", ";
    $query_string .= "`designation_ranking`=\"" . $designation_ranking[$sp_data['designation_code']] . "\", ";
    $query_string .= "`class`=\"" . $class[$sp_data['designation_code']] . "\",";
    $query_string .= "`pay_scale`=\"" . $payscale[$sp_data['designation_code']] . "\" ";

    /**
     * ------------------------------------------------------
     * // sanctioned post group code needed to be updated.
     * ------------------------------------------------------
     */
    /**
     * 
     * update query 
     * 
     * *****************************************************
     */    
    echo "\n\n\r------------------\n$row_count | "
    . $sp_data['org_code'] . " | "
    . $sp_data['org_name'] . " | "
    . $sp_data['id'] . ""
    . "\n--- ";
    $sql = "UPDATE `total_manpower_imported_sanctioned_post_copy` SET "
            . " $query_string "
            . "WHERE (`id`=\"" . $sp_data['id'] . "\")";
    $result = mysql_query($sql) or die(mysql_error() . "<p>update_$value_field_name:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

    if ($show_query) {
        echo "\n\r | $sql";
    }
}

/** * ***************************************************************************
 *  
 * Function definitions 
 * 
 * *****************************************************************************
 */
function getOrgInfoOfSanctionedPost($org_code) {
    if (!$org_code > 0) {
        return FALSE;
    }
    $sql = "SELECT
                    organization.org_name,
                    organization.org_code,
                    organization.division_code,
                    organization.division_name,
                    organization.district_code,
                    organization.district_name,
                    organization.upazila_thana_code,
                    organization.upazila_thana_name,
                    organization.union_code,
                    organization.union_name,
                    organization.org_type_code,
                    organization.org_type_name
            FROM
                    `organization`
            WHERE 
                    organization.org_code = $org_code";
    $org_result = mysql_query($sql) or die(mysql_error() . "<p>Code:getOrgLocationInfo:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

    $data = mysql_fetch_assoc($org_result);

    return $data;
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