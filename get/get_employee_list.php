<?php

require_once '../configuration.php';

$org_code = (int) mysql_real_escape_string($_POST['org_code']);
$organization_code = (int) mysql_real_escape_string($_POST['organization_id']);
$designation_id = (int) mysql_real_escape_string($_POST['designation_id']);

$sql = "SELECT
            total_manpower_imported_sanctioned_post_copy.id,
            total_manpower_imported_sanctioned_post_copy.staff_id
        FROM
            total_manpower_imported_sanctioned_post_copy
            AND total_manpower_imported_sanctioned_post_copy.active LIKE 1
        WHERE
            total_manpower_imported_sanctioned_post_copy.org_code = $organization_code
            
            ";
if ($designation_id > 0) {
    $sql .= " AND total_manpower_imported_sanctioned_post_copy.designation_id = $designation_id";
}

$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_designation_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

echo "<table class=\"table table-striped table-hover\">";
echo "<tr>";
echo "<th>Staff Id</th>";
echo "<th>Staff Name</th>";
echo "<th>Designation</th>";
echo "<th>Contact no.</th>";
echo "<th>Action</th>";
echo "</tr>";
while ($row = mysql_fetch_assoc($result)) {
//    print_r($row);
    if ($row['staff_id'] > 0) {
        $sql1 = "SELECT
                old_tbl_staff_organization.staff_id,
                old_tbl_staff_organization.staff_name,
                old_tbl_staff_organization.contact_no,
                old_tbl_staff_organization.department_id,
                old_tbl_staff_organization.staff_pds_code
            FROM
                old_tbl_staff_organization
            WHERE
                old_tbl_staff_organization.staff_id=" . $row['staff_id'];
        $result1 = mysql_query($sql1) or die(mysql_error() . "<br /><br />Code:<b>get_designation_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql1<br />");

        $value = mysql_fetch_assoc($result1);
//    print_r($value);
        echo "<tr>";
        echo "<td>" . $value['staff_id'] . "</td>";
        echo "<td><a href=\"employee.php?staff_id=" . $value['staff_id'] . "\" target=\"_blank\">" . $value['staff_name'] . "</a></td>";
        echo "<td>" . getStaffDepertmentFromDepertmentId($value['department_id']) . "</td>";
        echo "<td>" . $value['contact_no'] . "</td>";
        echo "<td><a href=\"move_staff.php?action=move_in&staff_id=" . $value['staff_id'] . "&org_code=$org_code\">Move In</a></td>";
        echo "</tr>";
    }
}
echo "</table>";
?>
