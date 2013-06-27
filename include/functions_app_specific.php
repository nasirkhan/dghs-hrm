<?php

/**
 * @description Get the organization type Name form the Organization code
 * @param type $org_code
 * @return string org_type_name
 */
function getOrgTypeNameFormOrgCode($org_code){
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
 * @description Get the organization type Name form the Organization type Id
 * @param type $org_type_id
 * @return string org_type_name
 */
function getOrgTypeNameFormOrgTypeId($org_type_id){  
    $sql = "SELECT org_type_id, org_type_code, org_type_name FROM org_type WHERE org_type_id = $org_type_id LIMIT 1";    
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgTypeNameFormOrgTypeId:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
    
    $org_type_data = mysql_fetch_assoc($result);
    $org_type_name = $org_type_data['org_type_name'];
    return $org_type_name;
}

/**
 * 
 * @param type $agency_code
 * @return type
 */
function getAgencyNameFromAgencyCode($agency_code){
    $sql = "SELECT org_agency_code_name FROM org_agency_code WHERE org_agency_code = $agency_code LIMIT 1";    
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getAgencyNameFromAgencyCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
    
    $org_data = mysql_fetch_assoc($result);
    $org_agency_code_name = $org_data['org_agency_code_name'];
    return $org_agency_code_name;
}

/**
 * 
 * @param type $functional_code
 * @return type
 */
function getFunctionalNameFromFunctionalCode($functional_code){
    $sql = "SELECT org_organizational_functions_name FROM org_organizational_functions WHERE org_organizational_functions_code = $functional_code LIMIT 1";    
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getFunctionalNameFromFunctionalCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
    
    $org_data = mysql_fetch_assoc($result);
    return $org_data['org_organizational_functions_name'];
}
?>
