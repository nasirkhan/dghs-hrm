<?php
/*
 * 	Check whether current user has permission to add client
 */
if (hasPermission($moduleName, $param, getLoggedUserName())) {
    $str = createMySqlUpdateString($_REQUEST, $exception_field);
    /*     * ********************************** */

    if(strlen($updatedbyFieldName)&&strlen($updatedbyFieldVal)){
        $str_additioal.= ",$updatedbyFieldName='$updatedbyFieldVal'";
    }
    if(strlen($updatedDateTimeFieldName)&&strlen($updatedDateTimeFieldVal)){
        $str_additioal.= ",$updatedDateTimeFieldName='$updatedDateTimeFieldVal'";
    }

    $sql = "UPDATE $dbTableName set $str $str_additioal where $dbTablePrimaryKeyFieldName='$dbTablePrimaryKeyFieldVal'";
    //echo "<pre>$sql</pre>"; //debug
    mysql_query($sql) or die(mysql_error() . "<b>Query:</b><br>$sql<br>");
    require_once 'cf_log.php';
    array_push($alert, "Information saved!");
} else {
    $valid = false;
    array_push($alert, "No permission to $param");
}
?>