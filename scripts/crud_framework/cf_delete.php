<?php
if (hasPermission($moduleName, $param, getLoggedUserName())) { // checks permission for delete
    if (deleteRow($dbTableName, " $dbTablePrimaryKeyFieldName='$dbTablePrimaryKeyFieldVal'")) {
        require_once 'cf_log.php';
        header("location:" . $_SERVER['PHP_SELF'] . "?param=$param" . "&msg=success");
    }
} else {
    $valid = false;
    array_push($alert, "No permission to $param");
}
?>