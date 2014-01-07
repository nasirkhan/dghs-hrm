<?php

if (!hasPermission($moduleName, 'view', getLoggedUserName())) { // checks permission to access this page
    echo "No view permission";
    exit();
} else {
    $valid = true; // action is valid. till this point :) but it becomes invalid if validation fails :(
    $alert = array(); // alert messages are pushed into this using array_push();
}
?>