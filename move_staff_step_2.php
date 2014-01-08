<?php

require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

require_once './include/check_org_code.php';

$govt_order = mysql_real_escape_string($_REQUEST['govt_order']);
$attachments = mysql_real_escape_string($_REQUEST['attachments']);
$staff_id = mysql_real_escape_string($_REQUEST['post_staff_id']);
$post_mv_from_org = mysql_real_escape_string($_REQUEST['post_mv_from_org']);
$post_mv_from_des = mysql_real_escape_string($_REQUEST['post_mv_from_des']);
$post_mv_to_org = mysql_real_escape_string($_REQUEST['post_mv_to_org']);
$post_mv_to_des = mysql_real_escape_string($_REQUEST['post_mv_to_des']);
$action_type = mysql_real_escape_string($_REQUEST['action_type']);


// redirect direct access
if (!$staff_id > 0) {
    if ($_SESSION['user_type'] == "admin") {
        header("location:admin_home.php");
    } else {
        header("location:home.php");
    }
}

$insert_ok = TRUE;



if ($insert_ok) {
    $sql = "INSERT INTO `transfer_post` (
                `request_submitted_by`, 
                `staff_id`, 
                `present_designation_id`, 
                `present_sanctioned_post_id`, 
                `present_org_code`, 
                `move_to_sanctioned_post_id`, 
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
//    echo "$sql";
}




/**
 * *****************************************************************************
 * 
 * Skip the approval process 
 * 
 * *****************************************************************************
 */

/**
 * 
 * Transfer || move in
 * 
 * ***************************************
 */
if ($action_type == "move_in") {
    // get the staff info form transfer_post table
    $sql = "SELECT * FROM transfer_post WHERE staff_id = $staff_id AND `active` = '1'";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>approveTransfer:1</p><p>Query:</b></br >___<p>$sql</p>");
    $data = mysql_fetch_assoc($result);

    $move_to_sanctioned_post_id = $data['move_to_sanctioned_post_id'];
    $move_to_org_code = $data['move_to_org_code'];


    if (!$move_to_sanctioned_post_id > 0) {
        $move_to_sanctioned_post_id = 0;
    }
    if (!$move_to_org_code > 0) {
        $move_to_org_code = 0;
    }

    // clean previous data | update staff table
    $sql = "UPDATE 
                old_tbl_staff_organization 
            SET 
                org_code=0, 
                sanctioned_post_id=0, 
                sp_id_2=0 
            WHERE 
                staff_id=$staff_id";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>approveTransfer:2</p><p>Query:</b></br >___<p>$sql</p>");


    // clean previous data | update staff table
    $sql = "UPDATE 
                old_tbl_staff_organization 
            SET 
                org_code=$move_to_org_code, 
                sanctioned_post_id=$move_to_sanctioned_post_id, 
                sp_id_2=$move_to_sanctioned_post_id 
            WHERE 
                staff_id=$staff_id";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>approveTransfer:2</p><p>Query:</b></br >___<p>$sql</p>");

    // update sanctioned post table
    $sql = "UPDATE 
                `total_manpower_imported_sanctioned_post_copy` 
            SET 
                staff_id_2 = 0 
            WHERE 
                staff_id_2 = $staff_id
            AND total_manpower_imported_sanctioned_post_copy.active LIKE 1";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>OMG:1</b></p><p><b>Query:</b></p>___<p>$sql</p>");
    

    // update sanctioned post table
    $sql = "UPDATE 
                `total_manpower_imported_sanctioned_post_copy` 
            SET 
                staff_id_2 = $staff_id 
            WHERE 
                id=$move_to_sanctioned_post_id
            AND total_manpower_imported_sanctioned_post_copy.active LIKE 1";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>OMG:1</b></p><p><b>Query:</b></p>___<p>$sql</p>");


    // update transfer_post table
    $sql = "UPDATE 
            transfer_post 
        SET 
            step_1_updated_by = \"$user_name\", 
            updated_by = \"$user_name\", 
            `active` = '0', 
            `status` = '2'
        WHERE 
            staff_id = $staff_id";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>approveTransfer:1</p><p>Query:</b></br >___<p>$sql</p>");
}

/**
 * 
 * Transfer || move out
 * 
 * ************************************************
 */ else if ($action_type == "move_out") {
    // get the staff info form transfer_post table
    $sql = "SELECT * FROM transfer_post WHERE staff_id = $staff_id AND `active` = '1'";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>approveTransfer:1</p><p>Query:</b></br >___<p>$sql</p>");
    $data = mysql_fetch_assoc($result);

    $move_to_sanctioned_post_id = $data['move_to_sanctioned_post_id'];
    $move_to_org_code = $data['move_to_org_code'];

    // clean previous data | update staff table
    $sql = "UPDATE 
                old_tbl_staff_organization 
            SET 
                org_code=0, 
                sanctioned_post_id=0, 
                sp_id_2=0 
            WHERE 
                staff_id=$staff_id";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>approveTransfer:2</p><p>Query:</b></br >___<p>$sql</p>");

    
    // update staff table
    $sql = "UPDATE 
                old_tbl_staff_organization 
            SET 
                org_code=$move_to_org_code, 
                sanctioned_post_id=$move_to_sanctioned_post_id, 
                sp_id_2=$move_to_sanctioned_post_id 
            WHERE 
                staff_id=$staff_id";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>approveTransfer:2</p><p>Query:</b></br >___<p>$sql</p>");

    
    
    // clean previous data | update staff table
    $sql = "UPDATE 
                old_tbl_staff_organization 
            SET 
                org_code=$move_to_org_code, 
                sanctioned_post_id=$move_to_sanctioned_post_id, 
                sp_id_2=$move_to_sanctioned_post_id 
            WHERE 
                staff_id=$staff_id";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>approveTransfer:2</p><p>Query:</b></br >___<p>$sql</p>");


    // update sanctioned post table
    $sql = "UPDATE 
                `total_manpower_imported_sanctioned_post_copy` 
            SET 
                staff_id_2 = '0' 
            WHERE 
                staff_id_2 = $staff_id
            AND total_manpower_imported_sanctioned_post_copy.active LIKE 1";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>OMG:1</b></p><p><b>Query:</b></p>___<p>$sql</p>");


    // update transfer_post table
    $sql = "UPDATE 
            transfer_post 
        SET 
            step_1_updated_by = \"$user_name\", 
            updated_by = \"$user_name\", 
            `active` = '0', 
            `status` = '2'
        WHERE 
            staff_id = $staff_id";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>approveTransfer:1</p><p>Query:</b></br >___<p>$sql</p>");
}


//    echo "$sql";
//echo "Success";


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

echo "ok";
?>