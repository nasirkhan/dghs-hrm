<?php

require_once '../configuration.php';

if ($_SESSION['logged'] != true) {
    header("location:login.php");
}



?>
