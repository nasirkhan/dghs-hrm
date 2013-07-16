<?php
require_once 'configuration.php';
$dis = $_GET['q'];

echo '<select id="org"  onChange="showOrgType(this.value)">
<option value="">--Select Org--</option>';
$dis = mysql_query("SELECT * FROM organization WHERE district_id='$dis' ORDER BY org_name");
while($rowdis = mysql_fetch_array($dis))
{
	echo '<option value="'.$rowdis['id'].'">'.$rowdis['org_name'].'</option>';
}
echo '</select>';


?>