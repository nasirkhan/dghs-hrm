<?php
require_once 'configuration.php';

$org_code = mysql_real_escape_string($_POST['org_code']);
$sql = "Delete FROM organization WHERE org_code=$org_code LIMIT 1";
$result = mysql_query($sql);

 print "<script>";
 print " self.location='delete.php'"; // Comment this line if you don't want to redirect
 print "</script>";

?>