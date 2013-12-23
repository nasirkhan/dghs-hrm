<?php

//get_org_list
require_once '../configuration.php';

$div_id = (int) mysql_real_escape_string($_POST['div_id']);
$dis_id = (int) mysql_real_escape_string($_POST['dis_id']);
$upa_id = (int) mysql_real_escape_string($_POST['upa_id']);
$agency_code = (int) mysql_real_escape_string($_POST['agency_code']);
//$type_code = (int) mysql_real_escape_string($_POST['type_code']);
$type_code = array();
$type_code = $_REQUEST['type_code'];
$type_code_count = count($type_code);

if (!$agency_code > 0) {
    $agency_code = 11;
}

$query_string = "";
if ($div_id > 0 || $dis_id > 0 || $upa_id > 0 || $agency_code > 0 || $type_code_count > 0) {
    $query_string .= " WHERE ";

    if ($agency_code > 0) {
        $query_string .= "organization.agency_code = $agency_code";
    }
    if ($upa_id > 0) {
        if ($agency_code > 0) {
            $query_string .= " AND ";
        }
        $query_string .= "organization.upazila_id = $upa_id";
    }
    if ($dis_id > 0) {
        if ($upa_id > 0 || $agency_code > 0) {
            $query_string .= " AND ";
        }
        $query_string .= "organization.district_id = $dis_id";
    }
    if ($div_id > 0) {
        if ($dis_id > 0 || $upa_id > 0 || $agency_code > 0) {
            $query_string .= " AND ";
        }
        $query_string .= "organization.division_id = $div_id";
    }
    if ($type_code_count > 0) {
        if ($div_id > 0 || $dis_id > 0 || $upa_id > 0 || $agency_code > 0) {
            $query_string .= " AND ";
        }
        $org_type_selected_array = "";
        for ($i = 0; $i < $type_code_count; $i++) {
            $org_type_selected_array .= " organization.org_type_code = '" . $type_code[$i] . "'";
            if ($i >= 0 && $i != $type_code_count - 1) {
                $org_type_selected_array .= " OR ";
            }
        }
        $query_string .= " ( $org_type_selected_array ) ";
    }
} else if (($div_id == 0 && $dis_id == 0 && $upa_id == 0 && $agency_code == 0) && $type_code > 0) {
    $org_type_selected_array = "";
    for ($i = 0; $i < $type_code_count; $i++) {
        $org_type_selected_array .= " organization.org_type_code = '" . $type_code[$i] . "'";
        if ($i >= 0 && $i != $type_code_count - 1) {
            $org_type_selected_array .= " OR ";
        }
    }
    $query_string .= " ( $org_type_selected_array ) ";
}

$query_string .= " ORDER BY org_name";

$sql = "SELECT
            organization.org_name,
            organization.org_code,
            organization.email_address1
        FROM
            organization
                    
            $query_string";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_org_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
//echo "$sql";

$row_count = mysql_num_rows($result);
if ($row_count > 0) {
    echo "\" Total $row_count Organization(s) found. \"";
    echo "<ul class=\"nav nav-pills nav-stacked\">";
    while ($data_list = mysql_fetch_assoc($result)) {
        echo "<li>";
        echo "<a href=\"org_profile.php?org_code=" . $data_list['org_code'] . "\" target=\"_blank\">";
        echo $data_list['org_name'];
        echo " (Org Code:" . $data_list['org_code'] . ")";
        echo " -- Email: " . $data_list['email_address1'];
        echo "</a>";
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "\" 0 (Zero) Organization found. \"";
}
?>
