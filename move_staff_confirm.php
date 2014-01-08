<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

require_once './include/check_org_code.php';

/**
 * Reassign org_code and enable edit permission for Upazila and below
 * 
 * Upazila users can edit the organizations under that UHC. 
 * Like the UHC users can edit the USC and USC(New) and CC organizations
 */
if ($org_type_code == 1029 || $org_type_code == 1051){  
    $org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));
    
    $org_info = getOrgDisCodeAndUpaCodeFromOrgCode($org_code);
    $parent_org_info = getOrgDisCodeAndUpaCodeFromOrgCode($_SESSION['org_code']);
    
    if (($org_info['district_code'] == $parent_org_info['district_code']) && ($org_info['upazila_thana_code'] == $parent_org_info['upazila_thana_code'])){
        $org_code = (int) mysql_real_escape_string(trim($_GET['org_code']));
        $org_name = getOrgNameFormOrgCode($org_code);
        $org_type_name = getOrgTypeNameFormOrgCode($org_code);
        $echoAdminInfo = " | " . $parent_org_info['upazila_thana_name'];
        $isAdmin = TRUE;
    }
}


$govt_order = mysql_real_escape_string($_POST['govt_order']);
$attachments = mysql_real_escape_string($_POST['attachments']);
$staff_id = mysql_real_escape_string($_POST['post_staff_id']);
$post_mv_from_org = mysql_real_escape_string($_POST['post_mv_from_org']);
$post_mv_from_des = mysql_real_escape_string($_POST['post_mv_from_des']);
$post_mv_to_org = mysql_real_escape_string($_POST['post_mv_to_org']);
$post_mv_to_des = mysql_real_escape_string($_POST['post_mv_to_des']);


// redirect direct access
if (!$staff_id > 0){
    if($_SESSION['user_type'] == "admin"){
        header("location:admin_home.php");
    }
    else {
        header("location:home.php");
    }    
}

$insert_ok = TRUE;



if ($insert_ok){
    $sql = "INSERT INTO `transfer_post` (
                `request_submitted_by`, 
                `staff_id`, 
                `present_designation_id`, 
                `present_sanctioned_post_id`, 
                `present_org_code`, 
                `move_to_designation_id`, 
                `move_to_org_code`, 
                `updated_by`, 
                `status`) 
            VALUES (
            '$user_name', 
            '$staff_id', 
            '$post_mv_from_des', 
            NULL, 
            '$post_mv_from_org', 
            '$post_mv_to_des', 
            '$post_mv_to_org', 
            '$user_name', 
            '1')";
    
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b> insertTransferRecord:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

}



$staff_name = getStaffNameFromId($staff_id);

$sanctioned_post_name_from = getSanctionedPostNameFromSanctionedPostId($post_mv_from_des);
$sanctioned_post_name_to = getSanctionedPostNameFromSanctionedPostGroupCode($post_mv_to_des);

$org_name_from = getOrgNameFormOrgCode($post_mv_from_org);
$org_name_to = getOrgNameFormOrgCode($post_mv_to_org);

?>