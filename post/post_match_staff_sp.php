<?php

require_once '../configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

$user_name = $_SESSION['username'];

$pk = mysql_real_escape_string($_POST['pk']);
$name = mysql_real_escape_string($_POST['name']);
$value = mysql_real_escape_string($_POST['value']);
$staff_id = mysql_real_escape_string($_POST['staff_id']);


if ($pk) {
    $sql = "UPDATE `dghs_hrm_main`.`old_tbl_staff_organization` 
            SET 
                `sp_id_2` = \"$value\",
                `last_update` = \"" . date("Y-m-d H:i:s") . "\",
                `updated_by` = \"$user_name\"   
            WHERE 
                `old_tbl_staff_organization`.`staff_id` = $staff_id;";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>post_match_staff_sp:1</b></p><p>Query:<br />___<br />$sql</p>");

//    echo "<pre>$sql<br><br><br>";
    

    $sql = "UPDATE `dghs_hrm_main`.`total_manpower_imported_sanctioned_post_copy` 
            SET 
                `staff_id_2` = \"$staff_id\",
                `updated_datetime` = \"" . date("Y-m-d H:i:s") . "\",
                `updated_by` = \"$user_name\"   
            WHERE 
                `total_manpower_imported_sanctioned_post_copy`.`id` = $value;";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>post_match_staff_sp:1</b></p><p>Query:<br />___<br />$sql</p>");

    
//    echo "$sql<br>";
    
    echo "Successfully Updated.";
} else {
    /*
      In case of incorrect value or error you should return HTTP status != 200.
      Response body will be shown as error message in editable form.
     */

    header('HTTP 400 Bad Request', true, 400);
    echo "This field is required!";
}
?>