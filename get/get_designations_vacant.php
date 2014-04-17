<?php

require_once '../configuration.php';

$organization_code = (int) mysql_real_escape_string($_POST['organization_code']);

$sql = "SELECT
                total_manpower_imported_sanctioned_post_copy.designation,
                total_manpower_imported_sanctioned_post_copy.sanctioned_post_group_code
        FROM
                total_manpower_imported_sanctioned_post_copy
        LEFT JOIN sanctioned_post_designation ON total_manpower_imported_sanctioned_post_copy.designation_code = sanctioned_post_designation.designation_code
        WHERE
                total_manpower_imported_sanctioned_post_copy.org_code = $organization_code
        AND total_manpower_imported_sanctioned_post_copy.active LIKE 1
        AND total_manpower_imported_sanctioned_post_copy.staff_id_2 = 0
        GROUP BY
                total_manpower_imported_sanctioned_post_copy.designation_id
        ORDER BY
                sanctioned_post_designation.ranking";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_designation_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
//echo "$sql";
$data = array();
$data[] = array(
    'text' => "Select Designation",
    'value' => 0
);
$data[] = array(
        'text' => "OSD",
        'value' => 0
    );
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['designation'],
        'value' => $row['sanctioned_post_group_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>
