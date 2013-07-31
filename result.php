<?php

require_once 'configuration.php';

if ($_REQUEST["designation"]) {
    $designation = mysql_real_escape_string($_REQUEST['designation']);
    $org_code = mysql_real_escape_string($_REQUEST['org_code']);
//   echo $designation;
}
$username = $_SESSION['username'];
//$org_code = $_SESSION['org_code'];


$sql = "SELECT
total_manpower_imported_sanctioned_post_copy.id,
total_manpower_imported_sanctioned_post_copy.class,
total_manpower_imported_sanctioned_post_copy.staff_id
FROM total_manpower_imported_sanctioned_post_copy
WHERE designation LIKE \"" . $designation . "\"
AND org_code =$org_code";
$sanctioned_post_list_result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

//$total_rows = mysql_num_rows($sanctioned_post_list_result);
while ($data_list = mysql_fetch_assoc($sanctioned_post_list_result)) {
//    if ($data_list['staff_id']==0){
//        $sql= "INSERT INTO `dghs_hrm_main`.`old_tbl_staff_organization` (`staff_id`, `sanctioned_post_id`, `organization_id`, `org_code`, `department_id`, `staff_posting`, `staff_job_class`, `staff_professional_category`, `designation_id`, `posting_status`, `staff_pds_code`, `staff_name`, `staff_local_id`, `father_name`, `mother_name`, `birth_date`, `email_address`, `contact_no`, `mailing_address`, `permanent_address`, `freedom_fighter_id`, `tribal_id`, `post_type_id`, `draw_type_id`, `designation_type_id`, `job_posting_id`, `working_status_id`, `draw_salary_id`, `sex`, `marital_status`, `religion`, `date_of_joining_to_govt_health_service`, `date_of_joining_to_current_place`, `date_of_joining_to_current_designation`, `professional_discipline_of_current_designation`, `type_of_educational_qualification`, `actual_degree`, `pay_scale_of_current_designation`, `current_basic_pay_taka`, `govt_quarter_id`, `job_status`, `reason`, `last_update`, `updated_by`) 
//            VALUES (NULL, '" . $data_list['id'] . "', NULL, $org_code, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, CURRENT_TIMESTAMP, '$username');";
//        $r = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
//        
//        $sql = "SELECT staff_id  FROM `old_tbl_staff_organization` WHERE `sanctioned_post_id` = " . $data_list['id'];
//        $r = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:3</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
//        
//        $sp_data = mysql_fetch_assoc($r);
//        $staff_id = $sp_data['staff_id'];
//        
//        $sql = "UPDATE `dghs_hrm_main`.`total_manpower_imported_sanctioned_post_copy` SET `staff_id` = '55198' WHERE `total_manpower_imported_sanctioned_post_copy`.`id` = $staff_id;";
//        $r = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:4</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
//    }
//    else{
//        $staff_id = $data_list['staff_id'];
//    }
    $staff_id = $data_list['staff_id'];
    $staff_name = getStaffNameFromId($staff_id);
    $data[] = array(
        "sanctioned_post_id" => $data_list['id'],
        "class" => $data_list['class'],
        "staff_id" => $staff_id,
        "staff_name" => $staff_name
    );
}


print json_encode($data);
?>