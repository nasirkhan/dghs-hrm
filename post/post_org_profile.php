<?php

require_once '../configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}
$org_code = $_SESSION['org_code'];


$pk = $_POST['pk'];
$name = $_POST['name'];
$value = $_POST['value'];

if ($pk == $org_code) {
    $sql = "UPDATE `dghs_hrm_main`.`organization` 
            SET 
                `$name` = \"$value\",
                `updated_datetime` = \"" . date("Y-m-d H:i:s") . "\",
                `updated_by` = \"$user_name\"   
            WHERE 
                `organization`.`org_code` = $pk;";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>post_employee:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

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