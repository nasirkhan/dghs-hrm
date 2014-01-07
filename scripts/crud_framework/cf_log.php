<?php

if ($storeLogInDatabase) {
    insertLog("$moduleName", "$param", "$dbTableName", "$dbTablePrimaryKeyFieldName", "$dbTablePrimaryKeyFieldVal", $sql, $loggedInUserKeyValue, print_r($_SERVER, true));
}
?>