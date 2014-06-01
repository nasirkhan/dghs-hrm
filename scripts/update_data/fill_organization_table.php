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
set_time_limit(18000);

/** ----------------------------------------------------------------------------
 *  
 * Function Call
 * 
 * -----------------------------------------------------------------------------
 */
echo "<pre>";


/**
 * org_type_code array
 */
$code = 'org_type_code';
$value = 'org_type_name';
$table = 'org_type';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$org_type = array();

while ($data = mysql_fetch_assoc($r)) {
    $org_type [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * agency_name array
 */
$code = 'org_agency_code';
$value = 'org_agency_name';
$table = 'org_agency_code';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$org_agency = array();

while ($data = mysql_fetch_assoc($r)) {
    $org_agency [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * org_organizational_functions array
 */
$code = 'org_organizational_functions_code';
$value = 'org_organizational_functions_name';
$table = 'org_organizational_functions';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$org_organizational_functions = array();

while ($data = mysql_fetch_assoc($r)) {
    $org_organizational_functions [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * org_organizational_functions array
 */
$code = 'org_level_code';
$value = 'org_level_name';
$table = 'org_level';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$org_level = array();

while ($data = mysql_fetch_assoc($r)) {
    $org_level [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}

/**
 * org_location_type array
 */
$code = 'org_location_type_code';
$value = 'org_location_type_name';
$table = 'org_location_type';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$org_location_type = array();

while ($data = mysql_fetch_assoc($r)) {
    $org_location_type [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}
$org_location_type[''] = "";

/**
 * admin_division array
 */
$code = 'division_bbs_code';
$value = 'division_name';
$table = 'admin_division';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$admin_division = array();

while ($data = mysql_fetch_assoc($r)) {
    $admin_division [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}
//print_r($admin_division);


/**
 * admin_district array
 */
$code = 'district_bbs_code';
$value = 'district_name';
$table = 'admin_district';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$admin_district = array();

while ($data = mysql_fetch_assoc($r)) {
    $admin_district [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}
//print_r($admin_district);

/**
 * org_ownership_authority array
 */
$code = 'org_ownership_authority_code';
$value = 'org_ownership_authority_name';
$table = 'org_ownership_authority';
$sql = "SELECT $code, $value FROM `$table`";
$r = mysql_query($sql) or die(mysql_error() . "<p>Code:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$org_ownership_authority = array();

while ($data = mysql_fetch_assoc($r)) {
    $org_ownership_authority [mysql_real_escape_string(trim($data[$code]))] = mysql_real_escape_string(trim($data[$value]));
}
//print_r($org_ownership_authority);

$show_query = TRUE;

/**
 * 
 * 
 * 
 * update query 
 */
$sql = "SELECT * FROM `organization` limit 50";
$org_result = mysql_query($sql) or die(mysql_error() . "<p>Code:getAllOrg:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$row_count = 0;
while ($org_data = mysql_fetch_assoc($org_result)) {
    $org_code = $org_data['org_code'];
    
    $row_count++;

    echo "<br /><br />------------------<br />$row_count | " . $org_data['org_code'] . " | " . $org_data['org_name'] . "<br />--- ";

    $sql = "UPDATE `organization` SET "
            . "`org_type_name`=\"" . $org_type[$org_data['org_type_code']] . "\","
            . "`agency_name`=\"" . $org_agency[$org_data['agency_code']] . "\", "
            . "`org_function_name`=\"" . $org_organizational_functions[$org_data['org_function_code']] . "\","
            . "`org_level_name`=\"" . $org_level[$org_data['org_level_code']] . "\","
            . "`org_location_type_name`=\"" . $org_location_type[$org_data['org_location_type']] . "\","
            . "`division_name`=\"" . $admin_division[$org_data['division_code']] . "\","
            . "`district_name`=\"" . $admin_district[$org_data['district_code']] . "\","
            . "`upazila_thana_name`=\"" . mysql_real_escape_string(trim(getUpazilaNamefromBBSCode($org_data['upazila_thana_code'], $org_data['district_code']))) . "\","
            . "`union_name`=\"" . mysql_real_escape_string(trim(getUnionNameFromBBSCode($org_data['union_code'], $org_data['upazila_thana_code'], $org_data['district_code']))) . "\","
            . "`ownership_authority_name`=\"" . $org_ownership_authority[$org_data['ownership_code']] . "\" "
            . "WHERE (`org_code`='$org_code')";
    $result = mysql_query($sql) or die(mysql_error() . "<p>update_$value_field_name:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

    if ($show_query) {
        echo "<br />| $sql";
    }
}
//
//
//$sql = "SELECT * FROM `organization`";
//$org_result = mysql_query($sql) or die(mysql_error() . "<p>Code:getAllOrg:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");
//
//$row_count = 0; 
//while ($org_data = mysql_fetch_assoc($org_result)) {
//    $row_count++;
//    
//    echo "<br /><br />------------------<br />$row_count | " . $org_data['org_code'] . " | " . $org_data['org_name'] . "<br />--- ";
//    // update org_type_name  
//    $code_field_name = 'org_type_code';
//    $value_field_name = 'org_type_name';
//    $code = $org_data[$code_field_name];    
//    $value = mysql_real_escape_string(trim(getOrgTypeNameFormOrgTypeCode($code)));
//    $show_query = TRUE;
//    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
//    
//    // update agency_name
//    $code_field_name = 'agency_code';
//    $value_field_name = 'agency_name';
//    $code = $org_data[$code_field_name];    
//    $value = mysql_real_escape_string(trim(getAgencyNameFromAgencyCode($code)));
//    $show_query = TRUE;
//    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
//    
//    
//    // update org_function_name
//    $code_field_name = 'org_function_code';
//    $value_field_name = 'org_function_name';
//    $code = $org_data[$code_field_name];    
//    $value = mysql_real_escape_string(trim(getOrgFucntionNameFromCode($code)));
//    $show_query = TRUE;
//    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
//    
//    // update org_level_name
//    $code_field_name = 'org_level_code';
//    $value_field_name = 'org_level_name';
//    $code = $org_data[$code_field_name];    
//    $value = mysql_real_escape_string(trim(getOrgLevelNamefromCode($code)));
//    $show_query = TRUE;
//    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
//    
//    // update org_location_type_name    
//    $code_field_name = 'org_location_type';
//    $value_field_name = 'org_location_type_name';
//    $code = $org_data[$code_field_name];    
//    $value = mysql_real_escape_string(trim(getOrgLocationTypeFromCode($code)));
//    $show_query = TRUE;
//    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
//    
//    // update division_name    
//    $code_field_name = 'division_code';
//    $value_field_name = 'division_name';
//    $code = $org_data[$code_field_name];    
//    $value = mysql_real_escape_string(trim(getDivisionNamefromCode($code)));
//    $show_query = TRUE;
//    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
//    
//    // update district_name    
//    $code_field_name = 'district_code';
//    $value_field_name = 'district_name';
//    $code = $org_data[$code_field_name];    
//    $value = mysql_real_escape_string(trim(getDistrictNamefromCode($code)));
//    $show_query = TRUE;
//    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
//        
//    // update upazila_thana_name    
//    $code_field_name = 'upazila_thana_code';
//    $value_field_name = 'upazila_thana_name';
//    $code = $org_data[$code_field_name];    
//    $value = mysql_real_escape_string(trim(getUpazilaNamefromBBSCode($code, $org_data['district_code'])));
//    $show_query = TRUE;
//    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
//        
//    // update union_name    
//    $code_field_name = 'union_code';
//    $value_field_name = 'union_name';
//    $code = $org_data[$code_field_name];    
//    $value = mysql_real_escape_string(trim(getUnionNameFromBBSCode($code, $org_data['upazila_thana_code'], $org_data['district_code'])));
//    $show_query = TRUE;
//    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
//        
//    // update ownership_authority_name    
//    $code_field_name = 'ownership_code';
//    $value_field_name = 'ownership_authority_name';
//    $code = $org_data[$code_field_name];    
//    $value = mysql_real_escape_string(trim(getOrgOwnarshioNameFromCode($code)));
//    $show_query = TRUE;
//    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
//    
////    echo "<br />--- ";
//}
//
///** * ***************************************************************************
// *  
// * Function definitions 
// * 
// * *****************************************************************************
// */
//
///**
// * 
// * @param type $code_field_name Column Name of the Code
// * @param type $code Code
// * @param type $value_field_name Column name of the Value
// * @param type $value Value
// * @param Boolean $show_query Show query or not
// */
//function update_org_data($code_field_name, $code, $value_field_name, $value, $show_query = false) {
//
//    $sql = "UPDATE `organization` SET `$value_field_name`=\"$value\" WHERE (`$code_field_name`='$code')";
//    $result = mysql_query($sql) or die(mysql_error() . "<p>update_$value_field_name:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");
//
//    if ($show_query) {
//        echo "<br />$value_field_name | $sql";
//    }
//}
