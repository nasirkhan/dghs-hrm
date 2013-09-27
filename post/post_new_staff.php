<?php

require_once '../configuration.php';

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


if (isset($_POST['new_staff'])) {
    print_r($_POST);
//    die();
    $staff_name = mysql_real_escape_string(trim($_POST['staff_name']));
    $father_name = mysql_real_escape_string(trim($_POST['father_name']));
    $mother_name = mysql_real_escape_string(trim($_POST['mother_name']));
    $email_address = mysql_real_escape_string(trim($_POST['email_address']));
    $contact_no = mysql_real_escape_string(trim($_POST['contact_no']));
    $sex = mysql_real_escape_string(trim($_POST['staff_sex']));
    $religion = mysql_real_escape_string(trim($_POST['staff_religion']));
    $marital_status = mysql_real_escape_string(trim($_POST['staff_marital_status']));
    $staff_job_class = mysql_real_escape_string(trim($_POST['staff_job_class_value']));
    $present_address = mysql_real_escape_string(trim($_POST['present_address']));
    $permanent_address = mysql_real_escape_string(trim($_POST['permanent_address']));
    
    
    $sql = "INSERT INTO `old_tbl_staff_organization` (
                `staff_name`, 
                `father_name`, 
                `mother_name`, 
                `email_address`, 
                `contact_no`, 
                `sex`, 
                `religion`,
                `marital_status`,
                `staff_job_class`,
                `present_address`,
                `permanent_address`,
                `updated_by`, 
                `status`) 
            VALUES (
            '$staff_name', 
            '$father_name', 
            '$mother_name', 
            '$email_address', 
            '$contact_no', 
            '$sex', 
            '$religion',
            '$marital_status',
            '$staff_job_class', 
            \"$present_address\", 
            \"$permanent_address\", 
            '" . $user_name . "', 
            '1')";
//    echo "$sql";
//    die();
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b> insertTransferRecord:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
    
    // unset $_POST value
    unset($_POST);
}


/**
 * *******************************
 * 
 * redirect to the Match Page
 * 
 * *******************************
 */
$url = "match_employee.php?org_code=$org_code";
redirect($url);

function redirect($url) {
    if (headers_sent()) {
        die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
    } else {
        header('Location: ' . $url);
        die();
    }
}


?>
