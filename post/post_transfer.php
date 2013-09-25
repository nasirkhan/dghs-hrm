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
    $sql = "UPDATE 
            transfer_post 
        SET 
            step_1_updated_by = \"$user_name\", 
            updated_by = \"$user_name\", 
            `active` = '0', 
            `status` = '2'
        WHERE 
            id = $id";
//    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>approveTransfer:1</p><p>Query:</b></br >___<p>$sql</p>");
    
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
//    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>approveTransfer:1</p><p>Query:</b></br >___<p>$sql</p>");
    echo "Updated";
}
?>
