<?php
require_once 'configuration.php';
$dis = $_GET['s'];

echo '<select id="upa">
<option value="">--Select Upazila--</option>';
$upa = mysql_query("SELECT * FROM admin_upazila WHERE district_id='$dis' ORDER BY upazila_name");
while($rowupa = mysql_fetch_assoc($upa))
{
	echo '<option value="'.$rowupa['id'].'">'.$rowupa['name'].'</option>';
}
echo '</select>';
?>