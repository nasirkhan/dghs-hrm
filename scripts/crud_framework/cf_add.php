<?php
/*
 * 	Check whether current user has permission to add client
 */
if (hasPermission($moduleName, $param, getLoggedUserName())) {
    /*
     * 	Create the insert query substring.
     */
    $str = createMySqlInsertString($_POST, $exception_field);
    $str_k = $str['k'];
    $str_v = $str['v'];

    if(strlen($updatedbyFieldName)&&strlen($updatedbyFieldVal)){
        $str_k_additional.= ",$updatedbyFieldName";
        $str_v_additional.= ",'$updatedbyFieldVal'";
    }
    if(strlen($updatedDateTimeFieldName)&&strlen($updatedDateTimeFieldVal)){
        $str_k_additional.= ",$updatedDateTimeFieldName";
        $str_v_additional.= ",'$updatedDateTimeFieldVal'";
    }
    /*     * ********************************** */

    $sql = "INSERT INTO $dbTableName($str_k $str_k_additional) values ($str_v $str_v_additional)";
    mysql_query($sql) or die(mysql_error() . "<b>Query:</b><br>$sql<br>");

    $dbTablePrimaryKeyFieldVal = mysql_insert_id();
    require_once 'cf_log.php';
    $param = 'edit';
    array_push($alert, "Information saved!");
} else {
    $valid = false;
    array_push($alert, "No permission to $param");
}
?>