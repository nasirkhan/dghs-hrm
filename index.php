<?php

require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
} else {
    if ($_SESSION['user_type'] == "admin") {
        header("location:admin_home.php");
    } else if ($_SESSION['user_type'] == "report_viewer") {
        header("location:report_index.php");
    } else {
        header("location:home.php?org_code=" . $_SESSION['org_code']);
    }
}
?>
