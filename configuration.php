<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();

/**
 * Application basic configuration
 */
$app_name = "DGHS HRM Application";
$site_name = "DGHS HRM";
$copyright = "DGHS";

/**
 * Database connection configuration
 *
 */
$dbhost = 'localhost';
$dbname = 'dghs_hrm_main';
$dbuser = 'root';
$dbpass = '';

mysql_select_db($dbname, mysql_connect($dbhost, $dbuser, $dbpass)) or die(mysql_error());
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection ='utf8_general_ci'");


$hrm_root_dir = "http://peugeot.websitewelcome.com/~hrmdghsm/hrm";
require_once 'include/config_variables.php';
require_once 'include/functions_app_specific.php';
require_once 'include/functions_generic.php';

if (getFileName() != 'login.php' && getFileName() != 'reset_password.php') {

    /* temporary code to avoid session issue */
    /*
    if ($_REQUEST[passcode] == '12345') {
        $_SESSION['logged'] = true;
    }
     *
     */
    /*     * ************************ */
    if (!isset($_SESSION['logged']) && $_SESSION['logged'] != true) {
        session_destroy();
        session_start();
        $str_k = "";
        $exception_field = array('');
        foreach ($_REQUEST as $k => $v) {
            if (!in_array($k, $exception_field)) {
                if (!empty($k)) {
                    $str_k.="$k=" . $v . '&';
                }
            }
        }
        $str_k = trim($str_k, '&');
        $_SESSION['redirect_url'] = getFileName() . '?' . $str_k;
        header("location:login.php"); // redirects to login.php page after storing the initially requested page.
    }
} else {
    if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
        header("location:index.php");
    }
}
?>
