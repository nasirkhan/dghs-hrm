<?php

require_once '../configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}

$staff_id = mysql_real_escape_string($_POST['staff_id']);
$sanctioned_post = mysql_real_escape_string($_POST['sanctioned_post']);
$new_sanctioned_post = mysql_real_escape_string($_POST['new_sanctioned_post']);
$govt_order = mysql_real_escape_string($_POST['govt_order']);
$comment = mysql_real_escape_string($_POST['comment']);
?>
