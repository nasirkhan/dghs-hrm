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

$sql = "SELECT * FROM `total_manpower_imported_sanctioned_post_copy` ORDER BY org_code limit 5";
$sp_result = mysql_query($sql) or die(mysql_error() . "<p>Code:getAllSanctionedPost:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

$row_count = 0; 
while ($sp_data = mysql_fetch_assoc($sp_result)){
    $row_count++;
    echo "<br /><br />------------------<br />$row_count | " 
            . $sp_data['org_code'] . " | " 
            . $sp_data['org_name'] . " | "
            . $sp_data['id'] . ""
            . "<br />--- ";
    
    
    // get org loaction data of this sanctioned post
    $org_location_data = getOrgInfoOfSanctionedPost($sp_data['org_code']);
    
    // update org_name
    $code_field_name = 'org_code';
    $value_field_name = 'org_name';
    $code = $sp_data[$code_field_name];    
    $value = $org_location_data['org_name'];
    $show_query = TRUE;
    update_sp_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    
    // update org_type_name
    $code_field_name = 'org_code';
    $value_field_name = 'org_type_name';
    $code = $sp_data[$code_field_name];    
    $value = $org_location_data['org_type_name'];
    $show_query = TRUE;
    update_sp_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    
    // update org_type_code
    $code_field_name = 'org_code';
    $value_field_name = 'org_type_code';
    $code = $sp_data[$code_field_name];    
    $value = $org_location_data['org_type_code'];
    $show_query = TRUE;
    update_sp_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    
    // update division_name
    $code_field_name = 'org_code';
    $value_field_name = 'division_name';
    $code = $sp_data[$code_field_name];    
    $value = $org_location_data['division_name'];
    $show_query = TRUE;
    update_sp_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    // update division_code
    $code_field_name = 'org_code';
    $value_field_name = 'division_code';
    $code = $sp_data[$code_field_name];    
    $value = $org_location_data['division_code'];
    $show_query = TRUE;
    update_sp_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    
    // update district_name
    $code_field_name = 'org_code';
    $value_field_name = 'district_name';
    $code = $sp_data[$code_field_name];    
    $value = $org_location_data['district_name'];
    $show_query = TRUE;
    update_sp_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    
    // update district_code
    $code_field_name = 'org_code';
    $value_field_name = 'district_code';
    $code = $sp_data[$code_field_name];    
    $value = $org_location_data['district_code'];
    $show_query = TRUE;
    update_sp_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    
    // update upazila_thana_name
    $code_field_name = 'org_code';
    $value_field_name = 'upazila_name';
    $code = $sp_data[$code_field_name];    
    $value = $org_location_data['upazila_thana_name'];
    $show_query = TRUE;
    update_sp_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    
    // update upazila_thana_code
    $code_field_name = 'org_code';
    $value_field_name = 'upazila_code';
    $code = $sp_data[$code_field_name];    
    $value = $org_location_data['upazila_thana_code'];
    $show_query = TRUE;
    update_sp_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    
    // update designation
    $code_field_name = 'designation_code';
    $value_field_name = 'designation';
    $code = $sp_data[$code_field_name];    
    $value = mysql_real_escape_string(trim(getDesignationNameformCode($code)));
    $show_query = TRUE;
    update_sp_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    
    // update bangladesh_professional_category_name
    $code_field_name = 'bangladesh_professional_category_code';
    $value_field_name = 'bangladesh_professional_category_name';
    $code = $sp_data[$code_field_name];    
    $value = mysql_real_escape_string(trim(getBangladeshProfessionalStaffCategoryFromCode($code)));
    $show_query = TRUE;
    update_sp_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    
    // update who_occupation_group_name
    $code_field_name = 'who_occupation_group_code';
    $value_field_name = 'who_occupation_group_name';
    $code = $sp_data[$code_field_name];    
    $value = mysql_real_escape_string(trim(getWhoProfessionalGroupNameFromCode($code)));
    $show_query = TRUE;
    update_sp_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    // get first level info
    $first_level_info = getFirstLevelInfoFromId($sp_data['first_level_id']);
    
    // update first_level_name
    $code_field_name = 'first_level_id';
    $value_field_name = 'first_level_name';
    $code = $sp_data[$code_field_name];    
    $value = mysql_real_escape_string(trim($first_level_info[$value_field_name]));
    $show_query = TRUE;
    update_sp_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    
    // update first_level_code
    $code_field_name = 'first_level_id';
    $value_field_name = 'first_level_code';
    $code = $sp_data[$code_field_name];    
    $value = mysql_real_escape_string(trim($first_level_info[$value_field_name]));
    $show_query = TRUE;
    update_sp_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    // get second level info
    $second_level_info = getSecondtLevelInfoFromId($sp_data['second_level_id']);
    
    // update second_level_name
    $code_field_name = 'second_level_id';
    $value_field_name = 'second_level_name';
    $code = $sp_data[$code_field_name];    
    $value = mysql_real_escape_string(trim($second_level_info[$value_field_name]));
    $show_query = TRUE;
    update_sp_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    
    // update second_level_code
    $code_field_name = 'second_level_id';
    $value_field_name = 'second_level_code';
    $code = $sp_data[$code_field_name];    
    $value = mysql_real_escape_string(trim($second_level_info[$value_field_name]));
    $show_query = TRUE;
    update_sp_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    // sanctioned post group code needed to be updated.
}


/** * ***************************************************************************
 *  
 * Function definitions 
 * 
 * *****************************************************************************
 */

function getOrgInfoOfSanctionedPost($org_code){
    if (!$org_code > 0){
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
                    `organization`";
    $org_result = mysql_query($sql) or die(mysql_error() . "<p>Code:getOrgLocationInfo:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");
    
    $data = mysql_fetch_assoc($org_result);
    
    return $data;
}

function update_sp_data ($code_field_name, $code, $value_field_name, $value, $show_query){
    if (!$code > 0){
        return FALSE;
    }
    $sql = "UPDATE `total_manpower_imported_sanctioned_post_copy` SET `$value_field_name`=\"$value\" WHERE (`$code_field_name`='$code')";
    $result = mysql_query($sql) or die(mysql_error() . "<p>update_$value_field_name:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

    if ($show_query) {
        echo "<br />$value_field_name | $sql";
    }
}

function getFirstLevelInfoFromId($code) {
    if (!$code > 0) {
        $data = ['first_level_code' => '0', 'first_level_name' => '0'];
        return $data;
    }

    $sql = "SELECT
                    *
            FROM
                    sanctioned_post_first_level
            WHERE
                    id = '$code'";
    $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:getFirstLevelInfoFromId:1</p><p>Query:</b></p>___<p>$sql</p>");

    $data = mysql_fetch_assoc($result);

    return $data;
}

function getSecondtLevelInfoFromId($code) {
    if (!$code > 0) {
        $data = ['second_level_code' => '0', 'second_level_name' => '0'];
        return $data;
    }

    $sql = "SELECT
                    *
            FROM
                    `sanctioned_post_second_level`
            WHERE
                    id = '$code'";
    $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:getSecondtLevelInfoFromId:1</p><p>Query:</b></p>___<p>$sql</p>");

    $data = mysql_fetch_assoc($result);

    return $data;
}