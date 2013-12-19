<script type="text/javascript">

    function confirmDelete(org_code) {
	    var org_code;
        if (confirm('Are you sure you want to delete this?')) {
            //Make ajax call
            $.ajax({
                url: "script_delete.php",
                type: "POST",
                data: {org_code : org_code},
                dataType: "html", 
                success: function() {
                    alert("It was succesfully deleted!");
                }
            });

        }
    }
</script>

<?php

//get_search_result
require_once '../configuration.php';

$type = mysql_real_escape_string(trim($_POST['type']));

$username = mysql_real_escape_string(trim($_POST['searchUser']));

$query_key = mysql_real_escape_string(trim($_POST['searchOrg']));

$query_staff = mysql_real_escape_string(trim($_POST['searchStaff']));

$searchStaffType = mysql_real_escape_string(trim($_POST['searchStaffType']));

$org_code = mysql_real_escape_string(trim($_POST['org_code']));


if ($query_key == "" && $username == "" && $query_staff == "") {

    echo "<div class=\"well well-large\"><em>Please Enter a Search Word.</em><div>";
    die();
}

if ($type == "user") {
    $sql = "SELECT 
                username, org_code
            FROM 
                `user` 
            WHERE 
                username LIKE \"%$username%\"";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_search_result:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
//    echo "$sql";

    $row_count = mysql_num_rows($result);
    if ($row_count > 0) {
        echo "\" Total $row_count Staff(s) found. \"";
        echo "<ul class=\"nav nav-pills nav-stacked\">";
        while ($data_list = mysql_fetch_assoc($result)) {
            echo "<li>";
            echo $data_list['username'] . " | " . getOrgNameFormOrgCode($data_list['org_code']) . " (Org Code:" . $data_list['org_code'] . ")";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "\" 0 (Zero) Staff found. \"";
    }
} else if ($type == "org") {
    $sql = "SELECT
            organization.org_name,
            organization.org_code
        FROM
            organization
        WHERE
            organization.org_code = \"$query_key\"
                OR
            organization.org_name LIKE \"%$query_key%\"
            ORDER BY org_name";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_search_result:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
    //echo "$sql";

    $row_count = mysql_num_rows($result);
    if ($row_count > 0) {
        echo "\" Total $row_count Organization(s) found. \"";
        echo "<ul class=\"nav nav-pills nav-stacked\">";
        while ($data_list = mysql_fetch_assoc($result)) {
             echo "<li>";
           // echo "<a href=\"#\" onclick='return confirmDelete(".$data_list['org_code'].")' target=\"_blank\">";
            echo $data_list['org_name'] . " (Org Code:" . $data_list['org_code'] . ")";
            echo "<a href=\"#\" onclick='return confirmDelete(".$data_list['org_code'].")' target=\"_blank\" style='display:inline;color:red;'>Delete</a>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "\" 0 (Zero) Organization found. \"";
    }
} else if ($type == "staff_org") {
    $sql = "SELECT
            organization.org_name,
            organization.org_code,
            organization.email_address1
        FROM
            organization
        WHERE
            organization.org_code = \"$query_key\"
                OR
            organization.org_name LIKE \"%$query_key%\"";
    $result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_search_result:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
//    echo "$sql";

    $row_count = mysql_num_rows($result);
    if ($row_count > 0) {
        echo "\" Total $row_count Organization(s) found. \"";
        echo "<ul class=\"nav nav-pills nav-stacked\">";
        while ($data_list = mysql_fetch_assoc($result)) {
            echo "<li>";
            echo "<a href=\"org_profile.php?org_code=" . $data_list['org_code'] . "\" target=\"_blank\">";
            echo $data_list['org_name'] . " (Org Code:" . $data_list['org_code'] . ")";
            echo "</a>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "\" 0 (Zero) Staff Organization found. \"";
    }
} else if ($type == "staff") {
    echo "<div class=\"well\">";
    $query_string = "";

    if ($searchStaffType == "searchStaffType_name") {
        $query_string = "staff_name LIKE \"%$query_staff%\"";
    } else if ($searchStaffType == "searchStaffType_mobile") {
        $query_string = "contact_no LIKE \"%$query_staff%\"";
    }

    $sql = "SELECT
                old_tbl_staff_organization.staff_id,
                old_tbl_staff_organization.staff_pds_code,
                old_tbl_staff_organization.org_code,
                old_tbl_staff_organization.staff_name,
                old_tbl_staff_organization.father_name,
                old_tbl_staff_organization.contact_no,
                old_tbl_staff_organization.birth_date
            FROM
                old_tbl_staff_organization
            WHERE $query_string
            ORDER BY old_tbl_staff_organization.org_code";
    $result = mysql_query($sql) or die(mysql_error() . "<p>Code:<b>get_search_result:1</b></p><p><b>Query:</b></p>___<p>$sql</p>");

    echo "<table class=\"table\">";
    echo "<thead><tr>";
    echo "<td>Staff Name</td>";
    echo "<td>Father's Name Name</td>";
    echo "<td>Organization</td>";
    echo "<td>Contact</td>";
    echo "<td>Action</td>";
    echo "</tr></thead>";

    echo "<tbody>";
    while ($data_list = mysql_fetch_assoc($result)) {


        echo "<tr>";
        echo "<td>";
        echo "<a href=\"employee.php?staff_id=" . $data_list['staff_id'] . "&org_code=" . $data_list['org_code'] . "\" target=\"_blank\">";
        echo $data_list['staff_name'] . " (ID:" . $data_list['staff_id'] . " | PDS:" . $data_list['staff_pds_code'] . ")";
        echo "</td>";
        echo "<td>";
        echo $data_list['father_name'];
        echo "</td>";
        echo "<td>";
        echo "</a>";
        echo getOrgNameFormOrgCode($data_list['org_code']);
        echo "</td>";
        echo "<td>";
        echo $data_list['contact_no'];
        echo "</td>";
        echo "<td>";
        echo "<a href=\"move_staff.php?action=move_in&staff_id=" . $data_list['staff_id'] . "&org_code=" . $org_code . "\" target=\"_blank\">";
        echo "Move In";
        echo "</a>";
        echo "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
//    echo "$sql";
    echo "</div>";
}
?>
