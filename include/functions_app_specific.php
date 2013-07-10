<?php

/**
 * Get the organization type Name form the Organization code
 * @param type $org_code
 * @return string org_type_name
 */
function getOrgTypeNameFormOrgCode($org_code) {
    $sql = "SELECT org_code, org_name, org_type_code, organization_id FROM organization WHERE org_code = $org_code  LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgTypeNameFormOrgCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);
    $org_type_code = $data['org_type_code'];

    $sql = "SELECT org_type_id, org_type_code, org_type_name FROM org_type WHERE org_type_id = $org_type_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgTypeNameFormOrgCode:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $org_type_data = mysql_fetch_assoc($result);
    $org_type_name = $org_type_data['org_type_name'];
    return $org_type_name;
}

/**
 * Get the organization type Name form the Organization type Id
 * @param type $org_type_id
 * @return string org_type_name
 */
function getOrgTypeNameFormOrgTypeId($org_type_code) {
    $sql = "SELECT org_type_id, org_type_code, org_type_name FROM org_type WHERE org_type_code = $org_type_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgTypeNameFormOrgTypeId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $org_type_data = mysql_fetch_assoc($result);
    $org_type_name = $org_type_data['org_type_name'];
    return $org_type_name;
}

/**
 * Get the Agency Name form the Agency Code
 * @param type $agency_code
 * @return type
 */
function getAgencyNameFromAgencyCode($agency_code) {
    $sql = "SELECT org_agency_code_name FROM org_agency_code WHERE org_agency_code = $agency_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getAgencyNameFromAgencyCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $org_data = mysql_fetch_assoc($result);
    $org_agency_code_name = $org_data['org_agency_code_name'];
    return $org_agency_code_name;
}

/**
 * Get <b>Functional Name</b> form the <b>Functional Code</b>
 * @param Int $functional_code
 * @return String
 */
function getFunctionalNameFromFunctionalCode($functional_code) {
    $sql = "SELECT org_organizational_functions_name FROM org_organizational_functions WHERE org_organizational_functions_code = $functional_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getFunctionalNameFromFunctionalCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $org_data = mysql_fetch_assoc($result);
    return $org_data['org_organizational_functions_name'];
}

/**
 * Get the <b>Organization Name</b> from the <b>Organization Code</b><b></b>
 * @param int $org_code Organization Code
 * @return String org_name Organization Name
 */
function getOrgNameFormOrgCode($org_code) {
    $sql = "SELECT organization.id,organization.org_name FROM organization WHERE organization.org_code = $org_code";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgNameFormOrgCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $org_data = mysql_fetch_assoc($result);
    return $org_data['org_name'];
}

/**
 * Get the <b>Organization Name</b> and <b>Organization Type Code</b>from the <b>Organization Code</b><b></b>
 * @param int $org_code Organization Code
 * @return String <b>Organization Name(org_name)</b> and <b>Organization Type Code (org_type_code)</b>
 */
function getOrgNameAndOrgTypeCodeFormOrgCode($org_code) {
    $sql = "SELECT organization.org_name,organization.org_type_code FROM organization WHERE organization.org_code = $org_code";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgNameFormOrgCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $org_data = mysql_fetch_assoc($result);

    $data['org_name'] = $org_data['org_name'];
    $data['org_type_code'] = $org_data['org_type_code'];

    return $data;
}

/**
 * Check if a staff works in a specific organization or not
 * @param Integer $org_code
 * @param Integer $staff_id
 * @return boolean 
 */
function checkEmployeeExistsInOrganization($org_code, $staff_id) {
    $sql = "SELECT old_tbl_staff_organization.org_code FROM old_tbl_staff_organization WHERE old_tbl_staff_organization.staff_id = $staff_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgNameFormOrgCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);
    if ($data['org_code'] == $org_code) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * Get the Username(Email address) of the users from the Organization Code
 * @param Int $org_code
 * @return String Username
 */
function getEmailAddressFromOrgCode($org_code) {
    $sql = "SELECT `username` FROM `user` WHERE `org_code` = $org_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getEmailAddressFromOrgCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['username'];
}

/**
 * Check if a username password pear is correct
 * @param type $username
 * @param type $password
 * @return boolean
 */
function checkPasswordIsCorrect($username, $password) {
    $sql = "SELECT `password` FROM `user` WHERE `username` like \"$username\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    $existing_pass = strtolower($data['password']);
    $get_pass = strtolower(md5($password));

    if ($existing_pass == $get_pass) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * Update a users password
 * @param type $username
 * @param type $password
 */
function updatePassword($username, $password) {
    $sql = "UPDATE dghs_hrm_main.user SET password = \"" . md5($password) . "\"WHERE user.username =\"$username\"";
    $result = mysql_query($sql) or die(mysql_error() . "<br />updatePassword:1<br /><b>Query:</b><br />___<br />$sql<br />");

//    $data = mysql_fetch_assoc($result);
}

/**
 * Get <b>Electricity Main Source Name</b> From <b>Electricity Main Source Code</b>
 * @param type $electricity_main_source_code
 * @return type
 */
function getElectricityMainSourceNameFromCode($electricity_main_source_code) {
    $sql = "SELECT `electricity_source_name` FROM `org_source_of_electricity_main` WHERE `electricity_source_code` = \"$electricity_main_source_code\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['electricity_source_name'];
}

/**
 * Get <b>Electricity Alternative Source Name</b> From <b>Electricity Alternative Source Code</b>
 * @param type $electricity_main_source_code
 * @return type
 */
function getElectricityAlterSourceNameFromCode($electricity_alter_source_code) {
    $sql = "SELECT `electricity_source_name` FROM `org_source_of_electricity_main` WHERE `electricity_source_code` = \"$electricity_alter_source_code\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getElectricityAlterSourceNameFromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['electricity_source_name'];
}

/**
 * Get <b>Water Main Source Name</b> From <b>Water Main Source Code</b>
 * @param type $water_source_code
 * @return type
 */
function getWaterMainSourceNameFromCode($water_source_code){
    $sql = "SELECT `water_supply_source_name` FROM `org_source_of_water_supply_main` WHERE `water_supply_source_code` = \"$water_source_code\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getWaterMainSourceNameFromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['water_supply_source_name'];
}


/**
 * Get <b>Water Alternative Source Name</b> From <b>Water Alternative Source Code</b>
 * @param type $water_source_code
 * @return type
 */
function getWaterAlterSourceNameFromCode($water_source_code){
    $sql = "SELECT `water_supply_source_name` FROM `org_source_of_water_supply_main` WHERE `water_supply_source_code` = \"$water_source_code\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getWaterAlterSourceNameFromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['water_supply_source_name'];
}

/**
 * Get <b>Toilet Type Name</b> From <b>Toilet Type Code</b>
 * @param type $toilet_type_code
 * @return type
 */
function getToiletTypeNameFromCode($toilet_type_code){
    $sql = "SELECT `toilet_type_name` FROM `org_toilet_type` WHERE `toilet_type_code` = \"$toilet_type_code\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getToiletTypeNameFromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['toilet_type_name'];
}

/**
 * Get <b>Toilet Adequacy Name</b> From <b>Toilet Adequacy Code</b>
 * @param type $toilet_adequacy_code
 * @return type
 */
function getToiletAdequacyNameFromCode($toilet_adequacy_code){
    $sql = "SELECT `toilet_adequacy_name` FROM `org_toilet_adequacy` WHERE `toilet_adequacy_code` = \"$toilet_adequacy_code\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getToiletAdequacyNameFromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['toilet_adequacy_name'];
}

/**
 * Get <b>Fuel Source Name</b> From <b>Fuel Source Code</b>
 * @param type $fuel_source_code
 * @return type
 */
function getFuelSourceNameFromCode($fuel_source_code){
    $sql = "SELECT `fuel_source_name` FROM `org_fuel_source` WHERE `fuel_source_code` = \"$fuel_source_code\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getToiletAdequacyNameFromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['fuel_source_name'];
}

/**
 * Get <b>Laundry Source Name</b> From <b>Laundry Source Code</b>
 * @param type $laundry_code
 * @return type
 */
function getLaundrySourceNameFromCode($laundry_code){
    $sql = "SELECT `laundry_system_name` FROM `org_laundry_system` WHERE `laundry_system_code` = \"$laundry_code\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getToiletAdequacyNameFromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['laundry_system_name'];
}

/**
 * Get <b>Autoclave Source Name</b> From <b>Autoclave Source Code</b>
 * @param type $laundry_code
 * @return type
 */
function getAutoclaveSystemNameFromCode($autoclave_code){
    $sql = "SELECT `autoclave_system_name` FROM `org_autoclave_system` WHERE `autoclave_system_code` = \"$autoclave_code\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getToiletAdequacyNameFromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['autoclave_system_name'];
}

/**
 * Get <b>Waste Disposal System Name</b> From <b>Waste Disposal System Code</b>
 * @param type $waste_disposal_code
 * @return type
 */
function getWasteDisposalSystemNameFromCode($waste_disposal_code){
    $sql = "SELECT `waste_disposal_system_name` FROM `org_waste_disposal_system` WHERE `waste_disposal_system_code` = \"$waste_disposal_code\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getToiletAdequacyNameFromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['waste_disposal_system_name'];
}



/**
 * Staff profile functions
 */


function getClassNameformId($class_code){
    $sql = "SELECT `class_name` FROM `sanctioned_post_class` WHERE `class_code` = \"$class_code\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getToiletAdequacyNameFromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['class_name'];
}

function getDesignationNameformCode($designation_code){
    $sql = "SELECT `designation` FROM `sanctioned_post_designation` WHERE `designation_code` = \"$designation_code\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getToiletAdequacyNameFromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['designation'];
}
?>
