<?php

if (strlen($_REQUEST['org_code'])) {
    if (isValidOrgCode($_REQUEST['org_code'])) {
        $org_code = $_REQUEST['org_code'];
        setOrgSession($org_code); // assign values from session array

        $org_code = $_SESSION['org_code'];
        $org_name = $_SESSION['org_name'];
        $org_type_name = $_SESSION['org_type_name'];

        $echoAdminInfo = " | Administrator";
        $isAdmin = TRUE;
    } else {
        echo "No valid org code found.";
        die();
    }
} else {
    echo "No org code found.";
    die();
}