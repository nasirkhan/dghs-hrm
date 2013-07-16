<?php
require_once 'configuration.php';
$dis = $_GET['q'];
$div = $_GET['p'];

$org = mysql_query("SELECT * FROM org_types");
echo '<select id="orgtype">
         <option value="">--Select OrgType--</option>';
	print_r($org);
	while($rorg = mysql_fetch_assoc($org))
	{
	  echo '<option value="'.$rorg['org_type_id'].'">'.$rorg['org_type_name'].'</option>';
	
}
echo '</select>';



?>