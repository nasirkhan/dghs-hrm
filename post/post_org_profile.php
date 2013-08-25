<?php

require_once '../configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

$org_code = $_SESSION['org_code'];
$user_name = $_SESSION['username'];

$pk = mysql_real_escape_string($_POST['pk']);
$name = mysql_real_escape_string($_POST['name']);
$value = mysql_real_escape_string($_POST['value']);

$post_type = mysql_real_escape_string($_POST['post_type']);
if ($post_type == "checklist"){
    $value = "[";
    for ($i = 0; $i < count($_POST['value'])-1; $i++) {
        $value .= $_POST['value'][$i] . ",";
    }
    $value .= $_POST['value'][$i] . "]";
}

//if ($_SESSION['user_type'] == "admin"){
//    $org_code = $pk;    
//}
//else{
//    $org_code = $_SESSION['org_code'];
//}


if ($pk == $org_code || $_SESSION['user_type'] == "admin") {
    $sql = "UPDATE `dghs_hrm_main`.`organization` 
            SET 
                `$name` = \"$value\",
                `updated_datetime` = \"" . date("Y-m-d H:i:s") . "\",
                `updated_by` = \"$user_name\"   
            WHERE 
                `organization`.`org_code` = $pk;";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>post_employee:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

    echo "Successfully Updated. <br> $sql";
} else {
    /*
      In case of incorrect value or error you should return HTTP status != 200.
      Response body will be shown as error message in editable form.
     */

    header('HTTP 400 Bad Request', true, 400);
    echo "This field is required!";
}
?>