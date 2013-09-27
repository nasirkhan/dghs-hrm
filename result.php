<?php

require_once 'configuration.php';

if ($_REQUEST["designation"]) {
    $designation = mysql_real_escape_string($_REQUEST['designation']);
    $org_code = mysql_real_escape_string($_REQUEST['org_code']);
}

$sql = "SELECT
total_manpower_imported_sanctioned_post_copy.id,
total_manpower_imported_sanctioned_post_copy.class,
total_manpower_imported_sanctioned_post_copy.staff_id,
total_manpower_imported_sanctioned_post_copy.staff_id_2
FROM total_manpower_imported_sanctioned_post_copy
WHERE designation LIKE \"" . $designation . "\"
AND org_code =$org_code";
$sanctioned_post_list_result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>sql:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

while ($data_list = mysql_fetch_assoc($sanctioned_post_list_result)) {
    $staff_id = $data_list['staff_id'];
    $staff_name = getStaffNameFromId($staff_id);
    $data[] = array(
        "sanctioned_post_id" => $data_list['id'],
        "class" => $data_list['class'],
        "staff_id" => $staff_id,
        "staff_id_2" => $staff_id_2,
        "staff_name" => $staff_name
    );
}


print json_encode($data);
?>