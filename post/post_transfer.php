<?php

require_once '../configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

$org_code = $_SESSION['org_code'];
$user_name = $_SESSION['username'];

$id = mysql_real_escape_string($_POST['id']);
$action = mysql_real_escape_string($_POST['action']);


if ($action == "approve") {
    // udpate the "transfer_post" table
    $sql = "UPDATE 
            transfer_post 
        SET 
            step_1_updated_by = \"$user_name\", 
            updated_by = \"$user_name\", 
            `active` = '0', 
            `status` = '2'
        WHERE 
            id = $id";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>approveTransfer:1</p><p>Query:</b></br >___<p>$sql</p>");
    
    // get the staff_id 
    $sql = "SELECT staff_id FROM transfer_post WHERE id= $id";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>approveTransfer:1</p><p>Query:</b></br >___<p>$sql</p>");
    $data = mysql_fetch_assoc($result);
    $staff_id = $data['staff_id'];
    $move_to_sanctioned_post_id = $data['move_to_sanctioned_post_id'];
    
    //update staff profile
    // unlink the connection with the organization and sanctioned post
    $sql = "UPDATE old_tbl_staff_organization SET org_code=0, sanctioned_post_id=0 WHERE staff_id=$staff_id LIMIT 1";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>approveTransfer:2</p><p>Query:</b></br >___<p>$sql</p>");
    echo "$sql";
    echo "Updated";
} else if ($action == "cancel") {
    $sql = "UPDATE 
            transfer_post 
        SET 
            step_1_updated_by = \"$user_name\", 
            updated_by = \"$user_name\", 
            `active` = '0', 
            `status` = '3'
        WHERE 
            id = $id";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>approveTransfer:1</p><p>Query:</b></br >___<p>$sql</p>");
    echo "Updated";
}
?>
