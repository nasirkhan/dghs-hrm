<?php

/**
 * Get the organization type Name form the Organization code
 * @param type $org_code
 * @return string org_type_name
 */
function getOrgTypeNameFormOrgCode($org_code) {
    if (!$org_code > 0) {
        return "";
    }

    $sql = "SELECT org_code, org_name, org_type_code, organization_id FROM organization WHERE org_code = $org_code  LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgTypeNameFormOrgCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);
    $org_type_code = $data['org_type_code'];

    if (!$org_type_code > 0) {
        return "";
    }

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
    if (!$org_type_code > 0) {
        return "";
    }
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
function getOrgTypeCodeFromOrgCode($org_code) {
    if (!$org_code > 0) {
        return "";
    }
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
    if (!$agency_code > 0) {
        return "";
    }
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
    if (!$functional_code > 0) {
        return "";
    }
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
    if (!$org_code > 0) {
        return "";
    }
    $sql = "SELECT organization.id,organization.org_name FROM organization WHERE organization.org_code = $org_code";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgNameFormOrgCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $org_data = mysql_fetch_assoc($result);
    return $org_data['org_name'];
}

/**
 * Get the <b>Organization Name</b> from the <b>Sanctioned post id</b><b></b>
 * @param int $org_code Organization Code
 * @return String org_name Organization Name
 */
function getOrgNameFormSanctionedPostId($sanctioned_post_id) {
    if (!$sanctioned_post_id > 0) {
        return "";
    }
    $sql = "SELECT
                total_manpower_imported_sanctioned_post_copy.org_name
            FROM
                total_manpower_imported_sanctioned_post_copy
            WHERE
                total_manpower_imported_sanctioned_post_copy.id = $sanctioned_post_id
            AND total_manpower_imported_sanctioned_post_copy.active LIKE 1
            LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgNameFormSanctionedPostId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $org_data = mysql_fetch_assoc($result);
    return $org_data['org_name'];
}

/**
 * Get the <b>Organization Name</b> and <b>Organization Type Code</b>from the <b>Organization Code</b><b></b>
 * @param int $org_code Organization Code
 * @return String <b>Organization Name(org_name)</b> and <b>Organization Type Code (org_type_code)</b>
 */
function getOrgNameAndOrgTypeCodeFormOrgCode($org_code) {
    if (!$org_code > 0) {
        return "";
    }
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
    if (!$org_code > 0 || !$staff_id > 0) {
        return "";
    }
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
 * Check if an Staff profile exists in the Staff table
 * @param INT $staff_id
 * @return boolean
 */
function checkStaffProfileExists($staff_id) {
    if (!$staff_id > 0)
        return FALSE;
    $sql = "SELECT
                count(1) as exists_status
            FROM
                old_tbl_staff_organization
            WHERE
                old_tbl_staff_organization.staff_id = $staff_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkStaffExists:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    if ($data['exists_status'] > 0) {
        $exists = TRUE;
    } else {
        $exists = FALSE;
    }

    return $exists;
}

/**
 * Check if a Sanctioned Post id is withing an Organziation
 * @param INT $staff_id
 * @return boolean
 */
function checkSanctionedPostWithinOrgFromSanctionedPostId($sanctioned_post_id, $org_code) {
    if (!$org_code > 0 || !$sanctioned_post_id > 0) {
        return "";
    }
    $sql = "SELECT
                Count(1) AS exists_status
            FROM
                total_manpower_imported_sanctioned_post_copy
            WHERE
                total_manpower_imported_sanctioned_post_copy.org_code = $org_code AND
                total_manpower_imported_sanctioned_post_copy.id = $sanctioned_post_id
            AND total_manpower_imported_sanctioned_post_copy.active LIKE 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkSanctionedPostWithinOrgFromSanctionedPostId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    if ($data['exists_status'] > 0) {
        $exists = TRUE;
    } else {
        $exists = FALSE;
    }

    return $exists;
}

/**
 * Check if an Staff exists in the total manpower table or not
 * @param INT $staff_id
 * @return boolean
 */
function checkStaffExists($staff_id) {
    if (!$staff_id > 0) {
        return "";
    }
    $sql = "SELECT id FROM total_manpower_imported_sanctioned_post_copy WHERE staff_id= $staff_id
            AND total_manpower_imported_sanctioned_post_copy.active LIKE 1 LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkStaffExists:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    if ($data['id'] > 0) {
        $exists = TRUE;
    } else {
        $exists = FALSE;
    }

    return $exists;
}

function checkStaffExistsBySanctionedPost($sanctioned_post_id) {
    if (!$sanctioned_post_id > 0) {
        return "";
    }
    $sql = "SELECT staff_id FROM total_manpower_imported_sanctioned_post_copy WHERE id= $sanctioned_post_id
            AND total_manpower_imported_sanctioned_post_copy.active LIKE 1 LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkStaffExistsBySanctionedPost:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $row = mysql_fetch_assoc($result);

    if ($row['staff_id_2'] > 0) {
        $data['staff_id'] = $row['staff_id_2'];
        $data['exists'] = TRUE;
    } else {
        $data['staff_id'] = $row['staff_id_2'];
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
    if (!$org_code > 0) {
        return "";
    }
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
    if (!$username > 0 || !$password > 0) {
        return "";
    }
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
    if (!$username > 0 || !$password > 0) {
        return "";
    }
    $user_name = $_SESSION['username'];
    $sql = "UPDATE dghs_hrm_main.user SET password = \"" . md5($password) . "\" ,
                `updated_datetime` = \"" . date("Y-m-d H:i:s") . "\",
                `updated_by` = \"$user_name\" WHERE user.username =\"$username\"";
    $result = mysql_query($sql) or die(mysql_error() . "<br />updatePassword:1<br /><b>Query:</b><br />___<br />$sql<br />");

    $to = "$user_name";
    // To send HTML mail, the Content-type header must be set
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "To: $to \r\n";
    $headers .= 'From: MIS DGHS <info@dghs.gov.bd>' . "\r\n";
    $subject = "[HRM] Email Notification for Password change ";
    $message = "Your password has been changed. ";
    $message .= "Your new password is " . $password;
    mail($to, $subject, $message, $headers);
}

/**
 * Get <b>Electricity Main Source Name</b> From <b>Electricity Main Source Code</b>
 * @param type $electricity_main_source_code
 * @return type
 */
function getElectricityMainSourceNameFromCode($electricity_main_source_code) {
    if (!$electricity_main_source_code > 0) {
        return "";
    }
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
    if (!$electricity_alter_source_code > 0) {
        return "";
    }
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
function getWaterMainSourceNameFromCode($water_source_code) {
    if (!$water_source_code > 0) {
        return "";
    }
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
function getWaterAlterSourceNameFromCode($water_source_code) {
    if (!$water_source_code > 0) {
        return "";
    }
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
function getToiletTypeNameFromCode($toilet_type_code) {
    if (!$toilet_type_code > 0) {
        return "";
    }
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
function getToiletAdequacyNameFromCode($toilet_adequacy_code) {
    if (!$toilet_adequacy_code > 0) {
        return "";
    }
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
function getFuelSourceNameFromCode($fuel_source_code) {
    if (!$fuel_source_code > 0) {
        return "";
    }
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
function getLaundrySourceNameFromCode($laundry_code) {
    if (!$laundry_code > 0) {
        return "";
    }
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
function getAutoclaveSystemNameFromCode($autoclave_code) {
    if (!$autoclave_code > 0) {
        return "";
    }
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
function getWasteDisposalSystemNameFromCode($waste_disposal_code) {
    if (!$waste_disposal_code > 0) {
        return "";
    }
    $sql = "SELECT `waste_disposal_system_name` FROM `org_waste_disposal_system` WHERE `waste_disposal_system_code` = \"$waste_disposal_code\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getToiletAdequacyNameFromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['waste_disposal_system_name'];
}

function getOrgLevelNamefromCode($org_level_code) {
    if (!$org_level_code > 0) {
        return "";
    }
    $sql = "SELECT `org_level_name` FROM `org_level` WHERE `org_level_code` = $org_level_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgLevelNamefromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['org_level_name'];
}

/**
 * Staff profile functions
 */
function getClassNameformId($class_code) {
    if (!$class_code > 0) {
        return "";
    }
    $sql = "SELECT `class_name` FROM `sanctioned_post_class` WHERE `class_code` = \"$class_code\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getClassNameformId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['class_name'];
}

function getDesignationNameformCode($designation_code) {
    if (!$designation_code > 0) {
        return "";
    }
    $sql = "SELECT `designation` FROM `sanctioned_post_designation` WHERE `designation_code` = \"$designation_code\" LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDesignationNameformCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['designation'];
}

/**
 *  get organization administration information
 */
function getDivisionNamefromCode($division_code) {
    if (empty($division_code)) {
        return "";
    }
    $sql = "SELECT *  FROM `admin_division` WHERE `division_bbs_code` =$division_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDivisionNamefromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['division_name'];
}

function getDistrictNamefromCode($bbs_code) {
    if (empty($bbs_code)) {
        return "";
    }
    $sql = "SELECT district_name  FROM `admin_district` WHERE `district_bbs_code` = $bbs_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDistrictNamefromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['district_name'];
}

function getUpazilaNamefromCode($bbs_code) {
    if (empty($bbs_code)) {
        return "";
    }
    $sql = "SELECT upazila_name  FROM `admin_upazila` WHERE `upazila_bbs_code` = $bbs_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getUpazilaNamefromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['upazila_name'];
}

function getUpazilaThanaNamefromCode($upa_bbs_code, $dis_bbs_code) {
    if (empty($upa_bbs_code) || empty($dis_bbs_code)) {
        return "";
    }
    $sql = "SELECT
                    admin_upazila.upazila_name
            FROM
                    admin_upazila
            WHERE
                    upazila_bbs_code = $upa_bbs_code
            AND upazila_district_code = $dis_bbs_code
            AND upazila_active LIKE 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getUpazilaNamefromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['upazila_name'];
}

function getUnionNamefromCode($bbs_code) {
    if (empty($bbs_code)) {
        return "";
    }
    $sql = "SELECT union_name  FROM `admin_union` WHERE `union_bbs_code` = $bbs_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getUnionNamefromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['union_name'];
}

function getDesignationNameFormSanctionedPostId($sanctioned_post_id) {
    if (empty($sanctioned_post_id)) {
        return "";
    }
    $sql = "SELECT designation FROM total_manpower_imported_sanctioned_post_copy WHERE id= $sanctioned_post_id
            AND total_manpower_imported_sanctioned_post_copy.active LIKE 1 LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDesignationNameFormSanctionedPostId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['designation'];
}

function getDesignationNameFormStaffId($staff_id) {
    if (empty($staff_id)) {
        return "";
    }
    $sql = "SELECT designation_id FROM old_tbl_staff_organization WHERE staff_id= $staff_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDesignationNameFormStaffId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    if (!$data['designation_id'] > 0)
        return "0";
    $sql = "SELECT designation FROM sanctioned_post_designation WHERE id = " . $data['designation_id'];
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDesignationNameFormStaffId:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['designation'];
}

function getSanctionedPostIdFromStaffId($staff_id) {
    if (empty($staff_id)) {
        return "";
    }
    $sql = "SELECT id FROM total_manpower_imported_sanctioned_post_copy WHERE staff_id= $staff_id
            AND total_manpower_imported_sanctioned_post_copy.active LIKE 1 LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDesignationNameFormSanctionedPostId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['id'];
}

function getSanctionedPostNameFromSanctionedPostId($SanctionedPostId) {
    if (empty($SanctionedPostId)) {
        return "";
    }
    $sql = "SELECT designation FROM total_manpower_imported_sanctioned_post_copy WHERE id= $SanctionedPostId
            AND total_manpower_imported_sanctioned_post_copy.active LIKE 1 LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDesignationNameFormSanctionedPostId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['designation'];
}

function getSanctionedPostNameFromSanctionedPostGroupCode($group_code) {
    if (empty($group_code)) {
        return "";
    }
    $sql = "SELECT designation FROM total_manpower_imported_sanctioned_post_copy WHERE sanctioned_post_group_code= $group_code
            AND total_manpower_imported_sanctioned_post_copy.active LIKE 1 LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getSanctionedPostNameFromStaffId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['designation'];
}

function getStaffNameFromStaffId($staff_id) {
    if (empty($staff_id)) {
        return "";
    }
    $sql = "SELECT staff_name FROM old_tbl_staff_organization WHERE staff_id= $staff_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDesignationNameFormSanctionedPostId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['staff_name'];
}

function getOrgOwnarshioNameFromCode($org_ownarship_code) {
    if (empty($org_ownarship_code)) {
        return "";
    }
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

function getOrgFunctionNameFromCode($org_function_code) {
    if (empty($org_function_code)) {
        return "";
    }
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
function getPostTypeFromId($post_type_id) {
    if (!$post_type_id > 0)
        return 0;
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
function getStaffPostingTypeFormId($posting_type_id) {
    if (!$posting_type_id > 0)
        return 0;
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

function getStaffDepertmentFromDepertmentId($depertment_id) {
    if (!$depertment_id > 0)
        return "0";
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

function getSalaryDrawTypeNameFromID($ID) {
    if (!$ID > 0)
        return "0";
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

function getSalaryDrawNameFromID($ID) {
    if (!$ID > 0)
        return "0";
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

function getSexNameFromId($id) {
    if (!$id > 0)
        return "0";
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

function getReligeonNameFromId($id) {
    if (!$id > 0)
        return "0";
    $sql = "SELECT
            staff_religious_group.religious_group_name
            FROM
            staff_religious_group
            WHERE
            religious_group_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getReligeonNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['religious_group_name'];
}

function getMaritalStatusFromId($id) {
    if (!$id > 0)
        return "0";
    $sql = "SELECT
            staff_marital_status.marital_status
            FROM
            staff_marital_status
            WHERE
            marital_status_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getMaritalStatusFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['marital_status'];
}

function getTribalNameFromId($id) {
    if (!$id > 0)
        return 0;
    $sql = "SELECT
            staff_tribal.tribal_value
            FROM
            staff_tribal
            WHERE
            tribal_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getTribalNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['tribal_value'];
}

function getFreedomFighterNameFromId($id) {
    if (!$id > 0)
        return 0;
    $sql = "SELECT
               staff_freedom_fighter.freedom_fighter_name
             FROM
                staff_freedom_fighter
              WHERE
            staff_freedom_fighter.freedom_fighter_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getFreedomFighterNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['freedom_fighter_name'];
}

// @todo must replace with database
function getProfessionalCategoryFromId($id) {
    if (!$id > 0)
        return 0;
    $sql = "SELECT
              staff_professional_category_type.professional_type_name
            FROM
              staff_professional_category_type
            WHERE
             professional_type_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getProfessionalCategoryFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['professional_type_name'];
}

// @todo must replace with database
function getDesignationTypeNameFromId($id) {
    if (!$id > 0)
        return 0;
    $sql = "SELECT
              staff_designation_type.designation_type
            FROM
             staff_designation_type
            WHERE
             designation_type_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDesignationTypeNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['designation_type'];
}

// @todo must replace with database
function getJobPostingNameFromId($id) {
    if (!$id > 0)
        return 0;
    $sql = "SELECT
            staff_job_posting.job_posting_name
            FROM
            staff_job_posting
            WHERE
            job_posting_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getJobPostingNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['job_posting_name'];
}

// @todo must replace with database
function getWorkingStatusNameFromId($id) {
    if (!$id > 0)
        return 0;
    $sql = "SELECT
            staff_working_status.working_status_name
            FROM
            staff_working_status
            WHERE
            working_status_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getWorkingStatusNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['working_status_name'];
}

// @todo must replace with database
function getDrawTypeNameFromId($id) {
    if (!$id > 0)
        return 0;
    $sql = "SELECT
            staff_salary_draw_type.salary_draw_type_name
            FROM
            staff_salary_draw_type
            WHERE
            salary_draw_type_id = $id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDrawTypeNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['salary_draw_type_name'];
}

function getFirstLevelNameFromID($first_level_id) {
    if (!$first_level_id > 0)
        return 0;
    $sql = "SELECT
                sanctioned_post_first_level.first_level_name
            FROM
                sanctioned_post_first_level
            WHERE
                sanctioned_post_first_level.first_level_code = $first_level_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getFirstLevelNameFromID:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['first_level_name'];
}

function getEducationalQualification($id) {
    if (!$id > 0)
        return 0;
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

function getGovtQuarter($id) {
    if (!$id > 0)
        return 0;
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

function getProfessionalDisciplineNameFromId($id) {
    if (!$id > 0)
        return 0;
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

/**
 * Sanctioned bed input field will be displayed for some specific organization
 * types, here it checks the organization by org_code
 * @param INT $org_type_code
 * @return boolean
 */
function showSanctionedBed($org_type_code) {
    $org_type_code = (int) $org_type_code;
    if ($org_type_code >= 1012 && $org_type_code <= 1018) {
        return FALSE;
    } else if ($org_type_code >= 1019 && $org_type_code <= 1020) {
        return TRUE;
    } else if ($org_type_code == 1021) {
        return FALSE;
    } else if ($org_type_code >= 1022 && $org_type_code <= 1029) {
        return TRUE;
    } else if ($org_type_code >= 1030 && $org_type_code <= 1032) {
        return FALSE;
    } else if ($org_type_code >= 1033 && $org_type_code <= 1036) {
        return TRUE;
    } else if ($org_type_code >= 1037 && $org_type_code <= 1040) {
        return FALSE;
    } else if ($org_type_code == 1041) {
        return TRUE;
    } else if ($org_type_code == 1042) {
        return FALSE;
    } else if ($org_type_code >= 1043 && $org_type_code <= 1044) {
        return TRUE;
    } else if ($org_type_code >= 1045 && $org_type_code <= 1055) {
        return FALSE;
    } else if ($org_type_code == 1056) {
        return TRUE;
    } else if ($org_type_code >= 1057 && $org_type_code <= 1059) {
        return FALSE;
    } else if ($org_type_code >= 1060 && $org_type_code <= 1061) {
        return TRUE;
    } else if ($org_type_code == 1062) {
        return FALSE;
    }
}

/**
 * Get Designation info(designation name, payscale, class) form designation Code
 * @param INT $des_code Designation Code
 * @return Array designation, payscale, class
 */
function getDesignationInfoFromCode($des_code) {
    if ($des_code <= 0) {
        return null;
    }
    $sql = "SELECT
                sanctioned_post_designation.designation,
                sanctioned_post_designation.payscale,
                sanctioned_post_designation.class
            FROM
                sanctioned_post_designation
            WHERE
                sanctioned_post_designation.designation_code = $des_code";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDesignationInfoFromCode:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data;
}

/**
 * Get depertment name from ID
 * @param INT $dept_name
 * @return STRIGN
 */
function getDeptNameFromId($dept_id) {
    if (!$dept_id > 0)
        return 0;
    $sql = "SELECT
                very_old_departments.dept_id,
                very_old_departments.department_id,
                very_old_departments.`name`
            FROM
                very_old_departments
            WHERE
                very_old_departments.department_id = $dept_id";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDeptNameFromId:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['name'];
}

/**
 * Get Staff name from Id
 * @param INT $staff_id
 * @return STRING
 */
function getStaffNameFromId($staff_id) {
    $sql = "SELECT
                old_tbl_staff_organization.staff_name
            FROM
                old_tbl_staff_organization
            WHERE
                old_tbl_staff_organization.staff_id = $staff_id";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b> getStaffNameFromId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);
    return $data['staff_name'];
}

/**
 * Get Org Code From Staff Id
 * @param INT $staff_id
 * @return INT org_code
 */
function getOrgCodeFromStaffId($staff_id) {
    if (!$staff_id > 0)
        return "";
    $sql = "SELECT
                old_tbl_staff_organization.org_code
            FROM
                old_tbl_staff_organization
            WHERE
                old_tbl_staff_organization.staff_id = $staff_id
            LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgCodeFromStaffId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);
    return $data['org_code'];
}

/**
 * Get all staff info from staff id
 * @param INT $staff_id
 * @return ARRAY
 */
function getStaffInfoFromStaffId($staff_id) {
    $sql = "SELECT
                *
            FROM
                old_tbl_staff_organization
            WHERE
                old_tbl_staff_organization.staff_id = $staff_id
            LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getStaffInfoFromStaffId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);
    return $data;
}

/**
 * Get the Sanctioned post "Type of post name" from Code
 * @param INT $type_of_post_code
 * @return STRING type_of_post_name
 */
function getPayScaleId($id) {
    if ($id <= 0) {
        return null;
    }
    $sql = "SELECT
                staff_pay_scale.pay_scale
            FROM
                staff_pay_scale
            WHERE
                staff_pay_scale.pay_scale_id = $id
            LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getTypeOfPostNameFromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);
    return $data['pay_scale'];
}

function getTypeOfPostNameFromCode($type_of_post_code) {
    if ($type_of_post_code <= 0) {
        return null;
    }
    $sql = "SELECT
                sanctioned_post_type_of_post.type_of_post_name
            FROM
                sanctioned_post_type_of_post
            WHERE
                sanctioned_post_type_of_post.type_of_post_code = $type_of_post_code
            LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getTypeOfPostNameFromCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);
    return $data['type_of_post_name'];
}

function getLastOrgIdFromOrganizationTable() {
    $sql = "SELECT org_code FROM organization ORDER BY id DESC LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getLastOrgIdFromOrganizationTable:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['org_code'];
}

/**
 * Get Division BBS Code Form the Old Division Id
 * @param INT $division_id
 * @return INT division_bbs_code
 */
function getDivisionCodeFormId($division_id) {
    $sql = "SELECT division_bbs_code FROM admin_division WHERE old_division_id = $division_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDivisionCodeFormId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['division_bbs_code'];
}

/**
 * Get District BBS Code Form the Old District Id
 * @param INT $district_id
 * @return INT district_bbs_code
 */
function getDistrictCodeFormId($district_id) {
    $sql = "SELECT district_bbs_code FROM admin_district WHERE old_district_id = $district_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getDivisionCodeFormId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['district_bbs_code'];
}

/**
 * Get Upazila BBS Code Form the Old Upazila Id
 * @param INT $upazila_id
 * @return INT upazila_bbs_code
 */
function getUpazilaCodeFormId($upazila_id) {
    $sql = "SELECT upazila_bbs_code FROM admin_upazila WHERE old_upazila_id = $upazila_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>getUpazilaCodeFormId:1</p><p>Query:</b></br >___<p>$sql</p>");

    $data = mysql_fetch_assoc($result);

    return $data['upazila_bbs_code'];
}

/**
 * Get username form Organization Code
 * @param INT $org_code
 * @return STRING username
 */
function getUserNameFromOrgCode($org_code) {
    $sql = "SELECT username FROM `user` WHERE org_code=$org_code LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>getDivisionCodeFormId:1</p><p>Query:</b></br >___<p>$sql</p>");

    $data = mysql_fetch_assoc($result);

    return $data['username'];
}

/**
 * Get Pay Scale form the Scanctioned post
 * @param INT $sanctioned_post_id
 * @return INT pay_scale
 */
function getPayScaleFromSanctionedPostId($sanctioned_post_id) {
    $sql = "SELECT
                    total_manpower_imported_sanctioned_post_copy.pay_scale
            FROM
                    total_manpower_imported_sanctioned_post_copy
            WHERE
                    id = $sanctioned_post_id
            AND total_manpower_imported_sanctioned_post_copy.active LIKE 1
            LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:3</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);

    return $data['pay_scale'];
}

/**
 * Get following info form org_code <br>
  organization.id,
  organization.org_name,
  organization.org_code,
  organization.org_type_code,
  organization.division_code,
  organization.division_name,
  organization.district_code,
  organization.district_name,
  organization.upazila_thana_code,
  organization.upazila_thana_name,
  organization.union_code,
  organization.union_name,
  organization.email_address1
 * @param INT $org_code
 * @return Array
 */
function getOrgInfoFromOrgCode($org_code) {
    $sql = "SELECT
                    organization.id,
                    organization.org_name,
                    organization.org_code,
                    organization.org_type_code,
                    organization.division_code,
                    organization.division_name,
                    organization.district_code,
                    organization.district_name,
                    organization.upazila_thana_code,
                    organization.upazila_thana_name,
                    organization.union_code,
                    organization.union_name
            FROM
                    organization
            WHERE
                    org_code = $org_code
            LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:getOrgInfoFromOrgCode:1</p><p>Query:</b></p>___<p>$sql</p>");
    $data = mysql_fetch_assoc($result);

//    print_r($data);
    $sql = "SELECT
                    org_name,
                    org_code,
                    email_address1
            FROM
                    organization
            WHERE
                upazila_thana_name LIKE \"" . $data['upazila_thana_name'] . "\"
            AND
                district_code = " . $data['district_code'] . "
            AND
                division_code = " . $data['division_code'] . "
            AND
                org_type_code = 1038";
    $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:getOrgInfoFromOrgCode:1</p><p>Query:</b></p>___<p>$sql</p>");

//    echo "$sql";
//    echo mysql_num_rows($result);
    $data = array();
    while ($row = mysql_fetch_array($result)) {
        $data[] = array(
            'org_name' => $row['org_name'],
            'org_code' => $row['org_code'],
            'email' => $row['email_address1']
        );
    }

    return $data;
}

/**
 * Get Bangladesh Professional Staff Category From Code
 *
 * @param INT $code
 * @return STRING bangladesh_professional_category_name
 */
function getBangladeshProfessionalStaffCategoryFromCode($code) {
    $sql = "SELECT
                    bangladesh_professional_category_name
            FROM
                    `sanctioned_post_bangladesh_professional_category`
            WHERE
                    bangladesh_professional_category_code = $code
            AND active LIKE 1";
    $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:getOrgInfoFromOrgCode:1</p><p>Query:</b></p>___<p>$sql</p>");

    $data = mysql_fetch_assoc($result);

    return $data['bangladesh_professional_category_name'];
}

/**
 * Get Bangladesh Professional Staff Category From Code
 *
 * @param INT $code
 * @return STRING bangladesh_professional_category_name
 */
function getWhoProfessionalGroupNameFromCode($code) {
    $sql = "SELECT
                    sanctioned_post_who_health_professional_group.who_health_professional_group_name
            FROM
                    `sanctioned_post_who_health_professional_group`
            WHERE
                    who_health_professional_group_code = $code
            AND active LIKE 1";
    $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:getWhoProfessionalGroupNameFromCode:1</p><p>Query:</b></p>___<p>$sql</p>");

    $data = mysql_fetch_assoc($result);

    return $data['who_health_professional_group_name'];
}

/**
 * Organization District Code And Upazila Code From org_Code
 * @param INT $org_code
 * @return ARRAY
 */
function getOrgDisCodeAndUpaCodeFromOrgCode($org_code) {
    $sql = "SELECT
                    district_code,
                    district_name,
                    upazila_thana_code,
                    upazila_thana_name
            FROM
                    `organization`
            WHERE
                    org_code = '$org_code'
            AND active LIKE 1";
    $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:getOrgDisCodeAndUpaCodeFromOrgCode:1</p><p>Query:</b></p>___<p>$sql</p>");

    $data = mysql_fetch_assoc($result);

    return $data;
}

/**
 * Get Organization Location Type Form code
 * @param INT $org_code
 * @return ARRAY
 */
function getOrgLocationTypeFromCode($org_location_code) {
    if (!$org_location_code > 0) {
        return null;
    }
    $sql = "SELECT
                    org_location_type_name
            FROM
                    org_location_type
            WHERE
                    org_location_type_code = $org_location_code
            AND active LIKE 1";
    $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:getOrgLocationTypeFromCode:1</p><p>Query:</b></p>___<p>$sql</p>");

    $data = mysql_fetch_assoc($result);

    return $data['org_location_type_name'];
}

function getTotalSanctionedPostCountFromOrgCode($org_code) {
    if (!$org_code > 0) {
        return "";
    }
    $sql = "SELECT
                    *
            FROM
                    total_manpower_imported_sanctioned_post_copy
            WHERE
                    org_code = '$org_code'
            AND active LIKE 1";
    $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:getTotalSanctionedPostCountFromOrgCode:1</p><p>Query:</b></p>___<p>$sql</p>");

    return mysql_num_rows($result);
}

function getTotalFilledUpSanctionedPostCountFromOrgCode($org_code) {
    if (!$org_code > 0) {
        return "";
    }
    $sql = "SELECT
                    *
            FROM
                    total_manpower_imported_sanctioned_post_copy
            WHERE
                    total_manpower_imported_sanctioned_post_copy.org_code = '$org_code'
            and total_manpower_imported_sanctioned_post_copy.staff_id_2 > 0
            AND total_manpower_imported_sanctioned_post_copy.active LIKE 1";
    $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:getTotalFilledUpSanctionedPostCountFromOrgCode:1</p><p>Query:</b></p>___<p>$sql</p>");

    return mysql_num_rows($result);
}

function getFirstLevelNameFromCode($code) {
    if (!$code > 0) {
        return "";
    }

    $sql = "SELECT
                    sanctioned_post_first_level.first_level_name
            FROM
                    sanctioned_post_first_level
            WHERE
                    first_level_code = '$code'
            AND active LIKE 1";
    $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:getFirstLevelNameFromCode:1</p><p>Query:</b></p>___<p>$sql</p>");

    $data = mysql_fetch_assoc($result);

    return $data['first_level_name'];
}

function getSecondtLevelNameFromCode($code) {
    if (!$code > 0) {
        return "";
    }

    $sql = "SELECT
                    sanctioned_post_second_level.second_level_name
            FROM
                    `sanctioned_post_second_level`
            WHERE
                    second_level_code = '$code'
            AND active LIKE 1";
    $result = mysql_query($sql) or die(mysql_error() . "<p><b>Code:getFirstLevelNameFromCode:1</p><p>Query:</b></p>___<p>$sql</p>");

    $data = mysql_fetch_assoc($result);

    return $data['second_level_name'];
}

function getUserInfoFromOrgCode($org_code) {
    $sql = "SELECT
                    `user`.username,
                    `user`.user_id,
                    `user`.id,
                    `user`.email,
                    `user`.`password`,
                    `user`.user_type,
                    `user`.user_type_code,
                    `user`.org_code
            FROM
                    `user`
            WHERE
                    org_code = '$org_code'
            AND active LIKE 1
            LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:getUserInfoFromOrgCode:1</p><p>Query:</br >___<p>$sql</p>");

    $data = mysql_fetch_assoc($result);

    return $data;
}

/**
 * handle user login
 * @param ARRAY $_POST
 * @return INT 0,1
 * @author Raihan Sikder <raihan.act@gmail.com>
 */
function login($POSTDATA) {
    $form_uname = mysql_real_escape_string(stripslashes(trim($POSTDATA['email'])));
    $form_passwd = mysql_real_escape_string(stripslashes(trim($POSTDATA['password'])));
    $form_passwd = md5($form_passwd);

    $sql = "SELECT user_id, username, user_type, user_type_code, organization_id, org_code FROM user WHERE username LIKE \"$form_uname\" AND password LIKE \"$form_passwd\"";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $data = mysql_fetch_assoc($result);
    //myprint_r($data); // debug


//    set session variables
    if (mysql_num_rows($result) >= 1) {
        if (setUserSession($data['username'])) {
            return 1;
        }
    }
    return 0;
}

/**
 * Sets session values for a successful login
 * @param  $user_id
 * @return bool
 * @author Raihan Sikder <raihan.act@gmail.com>
 */
function setUserSession($username) {

    //global $_SESSION;
    if ($user = getUserFromUsername($username)) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['user_type_code'] = $user['user_type_code'];

        $_SESSION['organization_id'] = $user['organization_id'];
        $_SESSION['org_code'] = $user['org_code'];
        $_SESSION['org_name'] = getOrgNameFormOrgCode($user['org_code']);
        $_SESSION['org_type_code'] = getOrgTypeCodeFromOrgCode($user['org_code']);
        $_SESSION['org_type_name'] = getOrgTypeNameFormOrgCode($user['org_code']);
        $_SESSION['logged'] = TRUE;
        session_write_close();
        return TRUE;
    }
    return FALSE;
}

/**
 * Get user from $user_id
 * @param  $user_id
 * @return array
 * @author Raihan Sikder <raihan.act@gmail.com>
 */
function getUserFromUsername($username) {
    return getRowVal('user', 'username', $username);
}


function getLoggedUserName(){
    return $_SESSION['username'];
}
?>
