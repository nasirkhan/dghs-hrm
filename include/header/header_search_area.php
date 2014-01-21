<?php

require_once '../../configuration.php';


if (hasPermission('mod_admin', 'view', getLoggedUserName())) {
    if (isset($_POST['search_type']) && isset($_POST['code'])) {
        $code = mysql_real_escape_string(stripslashes(trim($_POST['code'])));
        $search_type = mysql_real_escape_string(stripslashes(trim($_POST['search_type'])));

        /**
         * Search by Org Code
         */
        if ($search_type == "org_code") {
            if (isValidOrgCode($code)) {
                header("location:../../home.php?org_code=$code");
                echo "<script type=\"text/javascript\">window.location.href = \"../../home.php?org_code=$code\";</script>";
            } else {
                header("location:../../index.php");
                echo "<script type=\"text/javascript\">window.location.href = \"../../index.php\";</script>";
            }
        }

        /**
         * Search By Staff Id
         */
        if ($search_type == "staff_id") {
            if (isValidStaffId($code)) {
                header("location:../../employee.php?staff_id=$code");
            } else {
                header("location:../../index.php");
            }
        }

        /**
         * Search By Staff Mobile Number
         */
        if ($search_type == "staff_mobile") {
            $ivValidMobile = isValidStaffMobile($code);
            if ($ivValidMobile) {
                header("location:../../employee.php?staff_id=$ivValidMobile");
            } else {
                header("location:../../index.php");
            }
        }
    }
} else {
    header("location:index.php");
}
