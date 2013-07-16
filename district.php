<?php
require_once 'configuration.php';
$div = $_GET['q'];
echo '<select id="dis"  onChange="showOrg(this.value)">
<option value="">--Select District--</option>';
$dis = mysql_query("SELECT * FROM admin_district WHERE division_id='$div' ORDER BY district_name");
while($rowdis = mysql_fetch_array($dis))
{
	echo '<option value="'.$rowdis['id'].'">'.$rowdis['district_name'].'</option>';
}
echo '</select>';
?>