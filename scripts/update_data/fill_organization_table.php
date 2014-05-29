<?php

require_once '../../configuration.php';

//  Limit the maximum execution time
set_time_limit(1800);

/** ----------------------------------------------------------------------------
 *  
 * Function Call
 * 
 * -----------------------------------------------------------------------------
 */
echo "<pre>";

$sql = "SELECT * FROM `organization`";
$org_result = mysql_query($sql) or die(mysql_error() . "<p>Code:getAllOrg:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

while ($org_data = mysql_fetch_assoc($org_result)) {
    
    echo "<br /><br />------------------<br />" . $org_data['org_code'] . " | " . $org_data['org_name'] . "<br />--- ";
    // update org_type_name  
    $code_field_name = 'org_type_code';
    $value_field_name = 'org_type_name';
    $code = $org_data[$code_field_name];    
    $value = mysql_real_escape_string(trim(getOrgTypeNameFormOrgTypeCode($code)));
    $show_query = FALSE;
    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    // update agency_name
    $code_field_name = 'agency_code';
    $value_field_name = 'agency_name';
    $code = $org_data[$code_field_name];    
    $value = mysql_real_escape_string(trim(getAgencyNameFromAgencyCode($code)));
    $show_query = FALSE;
    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    
    // update org_function_name
    $code_field_name = 'org_function_code';
    $value_field_name = 'org_function_name';
    $code = $org_data[$code_field_name];    
    $value = mysql_real_escape_string(trim(getOrgFucntionNameFromCode($code)));
    $show_query = FALSE;
    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    // update org_level_name
    $code_field_name = 'org_level_code';
    $value_field_name = 'org_level_name';
    $code = $org_data[$code_field_name];    
    $value = mysql_real_escape_string(trim(getOrgLevelNamefromCode($code)));
    $show_query = FALSE;
    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    // update org_location_type_name    
    $code_field_name = 'org_location_type';
    $value_field_name = 'org_location_type_name';
    $code = $org_data[$code_field_name];    
    $value = mysql_real_escape_string(trim(getOrgLocationTypeFromCode($code)));
    $show_query = FALSE;
    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    // update division_name    
    $code_field_name = 'division_code';
    $value_field_name = 'division_name';
    $code = $org_data[$code_field_name];    
    $value = mysql_real_escape_string(trim(getDivisionNamefromCode($code)));
    $show_query = FALSE;
    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
    // update district_name    
    $code_field_name = 'district_code';
    $value_field_name = 'district_name';
    $code = $org_data[$code_field_name];    
    $value = mysql_real_escape_string(trim(getDistrictNamefromCode($code)));
    $show_query = FALSE;
    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
        
    // update upazila_thana_name    
    $code_field_name = 'upazila_thana_code';
    $value_field_name = 'upazila_thana_name';
    $code = $org_data[$code_field_name];    
    $value = mysql_real_escape_string(trim(getUpazilaNamefromBBSCode($code, $org_data['district_code'])));
    $show_query = FALSE;
    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
        
    // update union_name    
    $code_field_name = 'union_code';
    $value_field_name = 'union_name';
    $code = $org_data[$code_field_name];    
    $value = mysql_real_escape_string(trim(getUnionNameFromBBSCode($code, $org_data['upazila_thana_code'], $org_data['district_code'])));
    $show_query = FALSE;
    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
        
    // update ownership_authority_name    
    $code_field_name = 'ownership_code';
    $value_field_name = 'ownership_authority_name';
    $code = $org_data[$code_field_name];    
    $value = mysql_real_escape_string(trim(getOrgOwnarshioNameFromCode($code)));
    $show_query = FALSE;
    update_org_data($code_field_name, $code, $value_field_name, $value, $show_query);
    
//    echo "<br />--- ";
}

/** * ***************************************************************************
 *  
 * Function definitions 
 * 
 * *****************************************************************************
 */

/**
 * 
 * @param type $code_field_name Column Name of the Code
 * @param type $code Code
 * @param type $value_field_name Column name of the Value
 * @param type $value Value
 * @param Boolean $show_query Show query or not
 */
function update_org_data($code_field_name, $code, $value_field_name, $value, $show_query = false) {

    $sql = "UPDATE `organization` SET `$value_field_name`=\"$value\" WHERE (`$code_field_name`='$code')";
    $result = mysql_query($sql) or die(mysql_error() . "<p>update_$value_field_name:1<br /><br /><b>Query:</b><br />___<br />$sql</p>");

    if ($show_query) {
        echo "<br />$value_field_name | $sql";
    }
}
