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

function getOrgCodeFromSanctionedPostId($sanctioned_post) {
    $sql = "SELECT org_code FROM total_manpower_imported_sanctioned_post_copy WHERE id = $sanctioned_post LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>getOrgTypeNameFormOrgTypeCode:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $org_type_data = mysql_fetch_assoc($result);
    return $org_type_data['org_code'];
}

if (isset($_POST['new_staff'])) {
    print_r($_POST);
//    die();
    $staff_name = mysql_real_escape_string(trim($_POST['staff_name']));
    $staff_pds_code = mysql_real_escape_string(trim($_POST['staff_pds_code']));
    $father_name = mysql_real_escape_string(trim($_POST['father_name']));
    $mother_name = mysql_real_escape_string(trim($_POST['mother_name']));
    $contact_no = mysql_real_escape_string(trim($_POST['contact_no']));
    $sex = mysql_real_escape_string(trim($_POST['staff_sex']));
    $religion = mysql_real_escape_string(trim($_POST['staff_religion']));
    $marital_status = mysql_real_escape_string(trim($_POST['staff_marital_status']));
    $staff_job_class = mysql_real_escape_string(trim($_POST['staff_job_class_value']));
    $present_address = mysql_real_escape_string(trim($_POST['present_address']));
    $permanent_address = mysql_real_escape_string(trim($_POST['permanent_address']));
    $sanctioned_post = mysql_real_escape_string(trim($_POST['sanctioned_post']));
    $department_id = mysql_real_escape_string(trim($_POST['staff_department_id']));
    $staff_freedom_fighter = mysql_real_escape_string(trim($_POST['staff_freedom_fighter']));
    $staff_tribal_id = mysql_real_escape_string(trim($_POST['staff_tribal_id']));
    $staff_professional_categories = mysql_real_escape_string(trim($_POST['staff_professional_categories']));
    $staff_post_type_id = mysql_real_escape_string(trim($_POST['staff_post_type_id']));
    $actual_degree = mysql_real_escape_string(trim($_POST['actual_degree']));
    $staff_posting_type_id = mysql_real_escape_string(trim($_POST['staff_posting_type_id']));
    $staff_draw_salary_id = mysql_real_escape_string(trim($_POST['staff_draw_salary_id']));
    $staff_designation_type_id = mysql_real_escape_string(trim($_POST['staff_designation_type_id']));
    $posted_as = mysql_real_escape_string(trim($_POST['staff_job_posting_id']));
    $staff_working_status_id = mysql_real_escape_string(trim($_POST['staff_working_status_id']));
    $staff_salary_draw_type_id = mysql_real_escape_string(trim($_POST['staff_salary_draw_type_id']));
    $staff_pay_scale_id = mysql_real_escape_string(trim($_POST['staff_pay_scale_id']));
    $current_basic_pay_tk = mysql_real_escape_string(trim($_POST['current_basic_pay_tk']));
    $staff_educational_qualifiaction_Id = mysql_real_escape_string(trim($_POST['staff_educational_qualifiaction_Id']));
    $reason =mysql_real_escape_string(trim($_POST['reason']));
    $staff_govt_quarter = mysql_real_escape_string(trim($_POST['staff_govt_quarter']));
    $email_address1 = mysql_real_escape_string(trim($_POST['email_address1']));
   $staff_professional_discipline= mysql_real_escape_string(trim($_POST['staff_professional_discipline']));
    
    
    $sql = "INSERT INTO `old_tbl_staff_organization` (
                `staff_name`, 
                `staff_pds_code`,
                `sanctioned_post_id`,
                `sp_id_2`, 
                `org_code`,                
                `father_name`, 
                `mother_name`, 
                `email_address`, 
                `contact_no`, 
                `sex`, 
                `religion`,
                `marital_status`,
                `staff_job_class`,
                `mailing_address`,
                `permanent_address`,
                `department_id`,
                `designation_type_id`,
                `freedom_fighter_id`,
                `tribal_id`,
                `staff_professional_category`,
                `post_type_id`,
                `staff_posting`,
                `draw_salary_id`,
                `draw_type_id`,
                `job_posting_id`,
                `type_of_educational_qualification`,
                `pay_scale_of_current_designation`,
                `current_basic_pay_taka`,
                `working_status_id`,
                `actual_degree`,
                `professional_discipline_of_current_designation`,
                `govt_quarter_id`,
                `reason`,
                `updated_by`) 
            VALUES (
            '$staff_name', 
            '$staff_pds_code',   
            '$sanctioned_post',
            '$sanctioned_post', 
            '" . getOrgCodeFromSanctionedPostId($sanctioned_post) . "',
            '$father_name', 
            '$mother_name', 
            '$email_address1', 
            '$contact_no', 
            '$sex',  
            '$religion',
            '$marital_status',
            '$staff_job_class', 
            \"$present_address\", 
            \"$permanent_address\",
            '$department_id',
            '$staff_designation_type_id',
            '$staff_freedom_fighter',
            '$staff_tribal_id',
            '$staff_professional_categories',
            '$staff_post_type_id',
            '$staff_posting_type_id',
            '$staff_draw_salary_id',
            '$staff_salary_draw_type_id',
            '$posted_as',
            '$staff_educational_qualifiaction_Id',
            '$staff_pay_scale_id',    
            '$current_basic_pay_tk',  
            '$staff_working_status_id',
            '$actual_degree',
            '$staff_professional_discipline',
            '$staff_govt_quarter',
            '$reason',    
            '" . $user_name . "')";
//    echo "$sql";
//    die();
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b> insertTransferRecord:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    $sql = "SELECT staff_id FROM old_tbl_staff_organization WHERE sanctioned_post_id=$sanctioned_post";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b> insertTransferRecord:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
    $data = mysql_fetch_assoc($result);
    $staff_id = $data['staff_id'];

    $sql = "UPDATE total_manpower_imported_sanctioned_post_copy SET staff_id=$staff_id, staff_id_2=$staff_id WHERE id=$sanctioned_post";
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
$url = "http://test.dghs.gov.bd/hrmnew/match_employee.php?org_code=$org_code";
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
