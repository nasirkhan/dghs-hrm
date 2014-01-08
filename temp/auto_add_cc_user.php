<?php

//error_reporting(-1);
echo "<pre>";
require_once '../configuration.php';
echo "Auto user creation started...</br>";

$pass = 'RCHCIB1234';
$defaultpass["1039"] = md5($pass);
if ($_SESSION['logged'] != true) {
    header("location:../login.php");
}
echo "Did not redirect...</br>";
//error_reporting(-1);

$org_type_code = 1039; //
$limit = ""; //$limit = " LIMIT 0,3";


$sql = "select * from organization WHERE ((org_code NOT IN (SELECT org_code from user)) AND org_type_code='$org_type_code') $limit ";
echo "___<br/>".$sql."<br/>___<br/>";
$res = mysql_query($sql) or die(mysql_error() . "<b>Query:</b><br>$sql<br>");
echo "Query Successful...</br>";
if (mysql_num_rows($res)) {
    echo "One or more entries found...</br>";
    //$orgs = mysql_fetch_rowsarr($r);
    //echo "Storeds all rows in orgs...</br>";
    while ($org = mysql_fetch_array($res)) {
        if (strlen($org['email_address1']) && $org['email_address1']!='0') {
            $sql = "INSERT into user(
                username,email,
                password,
                user_type,
                org_code)
            values(
            '" . $org['email_address1'] . "',
            '" . $org['email_address1'] . "',
            '" . $defaultpass[$org['org_type_code']] . "',
            'user',
            '" . $org['org_code'] . "')";
            $r = mysql_query($sql) or mysql_error() . "<b>Query:</b><br>$sql<br>";
            if (mysql_affected_rows()>0) {
                echo "[SUCCESS]";
                //echo $org['org_type_code'] . "<br/>";
            } else {
                echo "[FAIL.  ] - May be an user exists with same name - ";
            }
        }else{
            echo "[FAIL   ] - No user/email found ";
        }
        echo " org_code ".$org['org_code'].", USER :" . $org['email_address1'] . " , PASS : $pass , md5 : " . $defaultpass[$org['org_type_code']] . "<br/>";
    }
} else {
    echo "No org found for which user needs to be created.";
}
echo "</pre>";

//if ($orgs = getRows('organization', " WHERE ((org_code NOT IN (SELECT org_code from user)) AND org_type_code='$org_type_code') $limit")) { // gets orgs that doesn't have user
?>