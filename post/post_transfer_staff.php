<?php

require_once '../configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}
$org_code = $_SESSION['org_code'];
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['username'];


$pk = mysql_real_escape_string($_POST['pk']);
$name = mysql_real_escape_string($_POST['name']);
$value = mysql_real_escape_string($_POST['value']);

if ($pk > 0 ){
    $sql = "UPDATE `transfer_queue` 
            SET 
                `$name` = \"$value\",
                `updated_by` = \"$user_name\"   
            WHERE 
                `id` = $pk;";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>post_transfer_staff:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

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