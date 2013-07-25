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

    $sql = "SELECT org_type_name  FROM `org_type` WHERE `org_type_code` = $org_type_code LIMIT 1";
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
function getOrgTypeNameFormOrgTypeCode($org_type_code) {
    $sql = "SELECT org_type_id, org_type_code, org_type_name FROM org_type WHERE org_type_code = $org_type_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgTypeNameFormOrgTypeCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $org_type_data = mysql_fetch_assoc($result);
    $org_type_name = $org_type_data['org_type_name'];
    return $org_type_name;
}


/**
 * Get <b>Organizaition Type Code</b> form the <b>Organization Code</b>
 * @param INT $org_code
 * @return INT org_type_code
 */
function getOrgTypeCodeFromOrgCode($org_code){
    $sql = "SELECT organization.org_type_code FROM organization WHERE organization.org_code = $org_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgTypeCodeFromOrgCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $org_type_data = mysql_fetch_assoc($result);
    return $org_type_data['org_type_code'];
}

/**
 * Get the Agency Name form the Agency Code
 * @param type $agency_code
 * @return type
 */
function getAgencyNameFromAgencyCode($agency_code) {
    $sql = "SELECT org_agency_name FROM org_agency_code WHERE org_agency_code = $agency_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getAgencyNameFromAgencyCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $org_data = mysql_fetch_assoc($result);
    $org_agency_code_name = $org_data['org_agency_name'];
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
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgNameAndOrgTypeCodeFormOrgCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

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
 * Check if an Staff exists in the total manpower table or not
 * @param INT $staff_id
 * @return boolean
 */
function checkStaffExists($staff_id){
    $sql = "SELECT id FROM total_manpower_imported_sanctioned_post_copy WHERE staff_id= $staff_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkStaffExists:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);
    
    if ($data['id'] > 0){
        $exists = TRUE;
    }
    else{
        $exists = FALSE;
    }
    
    return $exists;
}

function checkStaffExistsBySanctionedPost($sanctioned_post_id){
    $sql = "SELECT staff_id FROM total_manpower_imported_sanctioned_post_copy WHERE id= $sanctioned_post_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkStaffExistsBySanctionedPost:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $row = mysql_fetch_assoc($result);
    
    if ($row['staff_id'] > 0){
        $data['staff_id'] = $row['staff_id'];
        $data['exists'] = TRUE;
    }
    else{
        $data['staff_id'] = $row['staff_id'];
        $data['exists'] = FALSE;
    }
    
    return $data;
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
 * <b>THIS FUNCTION IS NOT REQUIRED ANY MORE</b>
 * 
 * Get <b>Fuel Source Name</b> From <b>Fuel Source Code</b>
 * 
 * @param type $fuel_source_code
 * @return type
 * 
 * @todo update or remove function
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

function getOrgLevelNamefromCode($org_level_code){
    $sql = "SELECT `org_level_name` FROM `org_level` WHERE `org_level_code` = $org_level_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgLevelNamefromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['org_level_name'];
}

/**
 * Staff profile functions
 */


function getClassNameformId($class_code){
    $sql = "SELECT `class_name` FROM `sanctioned_post_class` WHERE `class_code` = \"$class_code\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getClassNameformId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['class_name'];
}

function getDesignationNameformCode($designation_code){
    $sql = "SELECT `designation` FROM `sanctioned_post_designation` WHERE `designation_code` = \"$designation_code\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDesignationNameformCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['designation'];
}




/**
 *  get organization administration information
 */

function getDivisionNamefromCode($division_code){
    $sql = "SELECT *  FROM `admin_division` WHERE `division_bbs_code` =$division_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDivisionNamefromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['division_name'];
}

function getDistrictNamefromCode($bbs_code){
    $sql = "SELECT district_name  FROM `admin_district` WHERE `district_bbs_code` = $bbs_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDistrictNamefromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['district_name'];
}

function getUpazilaNamefromCode($bbs_code){
    $sql = "SELECT upazila_name  FROM `admin_upazila` WHERE `upazila_bbs_code` = $bbs_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getUpazilaNamefromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['upazila_name'];
}

function getUnionNamefromCode($bbs_code){
    $sql = "SELECT union_name  FROM `admin_union` WHERE `union_bbs_code` = $bbs_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getUnionNamefromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['union_name'];
}

function getDesignationNameFormSanctionedPostId($sanctioned_post_id){
    $sql = "SELECT designation FROM total_manpower_imported_sanctioned_post_copy WHERE id= $sanctioned_post_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDesignationNameFormSanctionedPostId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['designation'];
}

function getDesignationNameFormStaffId($staff_id){
    $sql = "SELECT designation_id FROM old_tbl_staff_organization WHERE staff_id= $staff_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDesignationNameFormSanctionedPostId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);
    
    $sql = "SELECT designation FROM old_designation WHERE id = " . $data['designation_id'];
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDesignationNameFormStaffId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['designation'];
}

function getSanctionedPostIdFromStaffId($staff_id){
    $sql = "SELECT id FROM total_manpower_imported_sanctioned_post_copy WHERE staff_id= $staff_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDesignationNameFormSanctionedPostId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['id'];
}

function getStaffNameFromStaffId ($staff_id){
    $sql = "SELECT staff_name FROM old_tbl_staff_organization WHERE staff_id= $staff_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDesignationNameFormSanctionedPostId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['staff_name'];
}

function getOrgOwnarshioNameFromCode($org_ownarship_code){
    $sql = "SELECT                
                org_ownership_authority.org_ownership_authority_name
            FROM
                org_ownership_authority
            WHERE
                org_ownership_authority.org_ownership_authority_code = $org_ownarship_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgOwnarshioNameFromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['org_ownership_authority_name'];
}

function getOrgFunctionNameFromCode($org_function_code){
    $sql = "SELECT
                org_organizational_functions.org_organizational_functions_name
            FROM
                org_organizational_functions
            WHERE
                org_organizational_functions.org_organizational_functions_code =  $org_function_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgFunctionNameFromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['org_organizational_functions_name'];
}

// get post type
function getPostTypeFromId($post_type_id){
    $sql = "SELECT
            staff_post_type.post_type_name
            FROM
            staff_post_type
            WHERE
            staff_post_type.post_type_id = $post_type_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getPostTypeFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['post_type_name'];
}

//staff_posting_type
function getStaffPostingTypeFormId($posting_type_id){
    $sql = "SELECT
            staff_posting_type.staff_posting_type_name
            FROM
            staff_posting_type
            WHERE
            staff_posting_type.staff_posting_type_id = $posting_type_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getStaffPostingTypeFormId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['staff_posting_type_name'];
}


function getStaffDepertmentFromDepertmentId($depertment_id){
    $sql = "SELECT
            very_old_departments.`name`
            FROM
            very_old_departments
            WHERE
            very_old_departments.department_id = $depertment_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getStaffDepertmentFromDepertmentId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['name'];
}


function getSalaryDrawTypeNameFromID($ID){
    $sql = "SELECT
            staff_salary_draw_type.salary_draw_type_name
            FROM
            staff_salary_draw_type
            WHERE
            staff_salary_draw_type.salary_draw_type_id = $ID LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getSalaryDrawTypeNameFromID:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['salary_draw_type_name'];
}


function getSalaryDrawNameFromID($ID){
    $sql = "SELECT
            staff_draw_salaray_place.draw_salaray_place
            FROM
            staff_draw_salaray_place
            WHERE
            staff_draw_salaray_place.draw_salary_id = $ID LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getSalaryDrawTypeNameFromID:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['draw_salaray_place'];
}

function getSexNameFromId($id){
     $sql = "SELECT
            staff_sex.sex_name
            FROM
            staff_sex
            WHERE
            sex_type_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getSexNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['sex_name'];

}

function getReligeonNameFromId($id){
     $sql = "SELECT
            staff_religious_group.religious_group_name
            FROM
            staff_religious_group
            WHERE
            religious_group_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getSexNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['religious_group_name'];
}

function getMaritalStatusFromId($id){
     $sql = "SELECT
            staff_marital_status.marital_status
            FROM
            staff_marital_status
            WHERE
            marital_status_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getSexNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['marital_status'];
}

function getTribalNameFromId($id){
    $sql = "SELECT
            staff_tribal.tribal_value
            FROM
            staff_tribal
            WHERE
            tribal_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getSexNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['tribal_value'];
}

function getFreedomFighterNameFromId($id){
    $sql = "SELECT
               staff_freedom_fighter.freedom_fighter_name
             FROM
                staff_freedom_fighter
              WHERE
            staff_freedom_fighter.freedom_fighter_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getSexNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['freedom_fighter_name'];
}


// @todo must replace with database
function getProfessionalCategoryFromId($id){
     $sql = "SELECT
              staff_professional_category_type.professional_type_name
            FROM
              staff_professional_category_type
            WHERE
             professional_type_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getSexNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['professional_type_name'];
}

// @todo must replace with database
function getDesignationTypeNameFromId($id){
     $sql = "SELECT
              staff_designation_type.designation_type
            FROM
             staff_designation_type
            WHERE
             designation_type_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getSexNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['designation_type'];
}

// @todo must replace with database
function getJobPostingNameFromId($id){
     $sql = "SELECT
            staff_job_posting.job_posting_name
            FROM
            staff_job_posting
            WHERE
            job_posting_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getSexNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['job_posting_name'];
}

// @todo must replace with database
function getWorkingStatusNameFromId($id){
        $sql = "SELECT
            staff_working_status.working_status_name
            FROM
            staff_working_status
            WHERE
            working_status_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getSexNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['working_status_name'];
}

// @todo must replace with database
function getDrawTypeNameFromId($id){
    $sql = "SELECT
            staff_salary_draw_type.salary_draw_type_name
            FROM
            staff_salary_draw_type
            WHERE
            salary_draw_type_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getSexNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['salary_draw_type_name'];
}

function getFirstLevelNameFromID($first_level_id){
    $sql = "SELECT
                sanctioned_post_first_level.first_level_name
            FROM
                sanctioned_post_first_level
            WHERE
                sanctioned_post_first_level.first_level_code = $first_level_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getSalaryDrawTypeNameFromID:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['first_level_name'];
}

function getEducationalQualification($id)
{
    $sql = "SELECT
                staff_educational_qualification.educational_qualification
            FROM
                staff_educational_qualification
            WHERE
               staff_educational_qualification.educational_qualifiaction_Id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getSalaryDrawTypeNameFromID:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['educational_qualification'];
}

function getGovtQuarter($id)
{
    $sql = "SELECT
                staff_govt_quater.govt_quater
            FROM
                staff_govt_quater
            WHERE
               staff_govt_quater.govt_quater_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getSalaryDrawTypeNameFromID:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['govt_quater'];
}



function getProfessionalDisciplineNameFromId($id)
{
     $sql = "SELECT
                staff_profesional_discipline.discipline_name
            FROM
               staff_profesional_discipline
            WHERE
               staff_profesional_discipline.discipline_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getSalaryDrawTypeNameFromID:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['discipline_name'];
}


function showSanctionedBed($org_type_code){
    $org_type_code = (int) $org_type_code;
    if($org_type_code >= 1012 && $org_type_code <= 1018){
        return FALSE;
    }
    else if ($org_type_code >= 1019 && $org_type_code <= 1020){
        return TRUE;
    }
    else if ($org_type_code == 1021){
        return FALSE;
    }
    else if ($org_type_code >= 1022 && $org_type_code <= 1029){
        return TRUE;
    }
    else if ($org_type_code >= 1030 && $org_type_code <= 1032){
        return FALSE;
    }
    else if ($org_type_code >= 1033 && $org_type_code <= 1036){
        return TRUE;
    }
    else if ($org_type_code >= 1037 && $org_type_code <= 1040){
        return FALSE;
    }
    else if ($org_type_code == 1041){
        return TRUE;
    }
    else if ($org_type_code == 1042){
        return FALSE;
    }
    else if ($org_type_code >= 1043 && $org_type_code <= 1044){
        return TRUE;
    }
    else if ($org_type_code >= 1045 && $org_type_code <= 1055){
        return FALSE;
    }
    else if ($org_type_code == 1056){
        return TRUE;
    }
    else if ($org_type_code >= 1057 && $org_type_code <= 1059){
        return FALSE;
    }
    else if ($org_type_code >= 1060 && $org_type_code <= 1061){
        return TRUE;
    }
    else if ($org_type_code == 1062){
        return FALSE;
    }
}

?>
