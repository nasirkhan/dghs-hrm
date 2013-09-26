<?php
require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

// assign values from session array
$org_code = $_SESSION['org_code'];
$org_name = $_SESSION['org_name'];
$org_type_name = $_SESSION['org_type_name'];
$user_name = $_SESSION['username'];

$echoAdminInfo = "";

// assign values admin users
if ($_SESSION['user_type'] == "admin" && $_REQUEST['org_code'] != "") {
    $org_code = (int) mysql_real_escape_string($_REQUEST['org_code']);
    $org_name = getOrgNameFormOrgCode($org_code);
    $org_type_name = getOrgTypeNameFormOrgCode($org_code);
    $echoAdminInfo = " | Administrator";
    $isAdmin = TRUE;
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
            '$post_mv_from_des', 
            '$post_mv_from_org', 
            '$post_mv_to_des', 
            '$post_mv_to_org', 
            '$user_name', 
            '1')";
    
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b> insertTransferRecord:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

}

header("match_employee.php?org_code=$org_code");

?>