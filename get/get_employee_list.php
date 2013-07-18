<?php

require_once '../configuration.php';

$organization_code = (int) mysql_real_escape_string($_POST['organization_id']);
$designation_id = (int) mysql_real_escape_string($_POST['designation_id']);

$sql = "SELECT
            total_manpower_imported_sanctioned_post_copy.id,
            total_manpower_imported_sanctioned_post_copy.staff_id
        FROM
            total_manpower_imported_sanctioned_post_copy
        WHERE
            total_manpower_imported_sanctioned_post_copy.org_code = $organization_code
            AND 
            total_manpower_imported_sanctioned_post_copy.designation_id = $designation_id
            ";

$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_designation_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

echo "<table class=\"table table-striped table-hover\">";
while ($row = mysql_fetch_assoc($result)) {
//    print_r($row);
    $sql1 = "SELECT
                old_tbl_staff_organization.staff_id,
                old_tbl_staff_organization.staff_name,
                old_tbl_staff_organization.contact_no,
                old_tbl_staff_organization.staff_pds_code
            FROM
                old_tbl_staff_organization
            WHERE
                old_tbl_staff_organization.staff_id=" . $row['staff_id'];
    $result1 = mysql_query($sql1) or die(mysql_error() . "<br /><br />Code:<b>get_designation_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql1<br />");
    
    $value = mysql_fetch_assoc($result1);
    print_r($value);
    echo "<tr>";
    echo "<td>" . $value['staff_id'] . "</td>";
    echo "<td>" . $value['staff_name'] . "</td>";
    echo "<td>" . $value['contact_no'] . "</td>";
    echo "<td>" . $value['staff_pds_code'] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
