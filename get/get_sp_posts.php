<?php
require_once '../configuration.php';

if (isset($_REQUEST["first_level_id"])) {
    $first_level_id = mysql_real_escape_string($_REQUEST['first_level_id']);
}
if (isset($_REQUEST["second_level_id"])) {
    $second_level_id = mysql_real_escape_string($_REQUEST['second_level_id']);
}
if (isset($_REQUEST["designation"])) {
    $designation = mysql_real_escape_string($_REQUEST['designation']);
}

$org_code = $_SESSION['org_code'];

$sql = "SELECT
total_manpower_imported_sanctioned_post_copy.id,
total_manpower_imported_sanctioned_post_copy.class,
total_manpower_imported_sanctioned_post_copy.staff_id
FROM total_manpower_imported_sanctioned_post_copy
WHERE designation LIKE \"" . $designation . "\"
AND org_code =$org_code";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_sp_second_level:3</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

//$total_rows= mysql_num_rows($sanctioned_post_list_result);

echo "<table class=\"table\">";
while ($data_list = mysql_fetch_assoc($result)) {
    echo "<tr class=\"warning\">";
    echo "<td width=\"50%\">Sanctioned Post Id" . $data_list['id'] . " (Staff Id:" . $data_list['staff_id'] . ")</td>";
    echo "<td>";
    echo "<a href=\"employee.php?staff_id=" . $data_list['staff_id'] . "&sanctioned_post_id=" . $data_list['id'] . "\" target=\"_blank\"  class=\"btn btn-primary btn-xs\" ><i class=\"icon-user\"></i> View Profile</a>";
//    echo "<button class=\"btn btn-sm\" id=\"designation" . $data_list['designation_code'] . "\"type=\"button\"><i class=\"icon-list-ul\"></i> View Sanctioned Posts</button>";
    echo "</td>";
    echo "</tr>";    
}
echo "</table>";
?>