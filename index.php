<?php

require_once 'configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
} else {
    if ($_SESSION['user_type'] == "admin"){
        header("location:admin_home.php");
    }
    else {
        header("location:home.php?org_code=" . $_SESSION['org_code']);
    }
}
?>
