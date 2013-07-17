<?php

require_once '../configuration.php';

$div_id = (int) mysql_real_escape_string($_POST['div_id']);
$dis_id = (int) mysql_real_escape_string($_POST['dis_id']);
$upa_id = (int) mysql_real_escape_string($_POST['upa_id']);
$agency_code = (int) mysql_real_escape_string($_POST['agency_code']);

$query_string = "";


if ($upa_id > 0){
    $query_string = " AND organization.upazila_id = $upa_id";
}
else if ($dis_id > 0){
    $query_string = " AND organization.district_id = $dis_id";
}
else if ($div_id > 0){
    $query_string = " AND organization.district_id = $div_id";
}
$query_string .= " ORDER BY org_name";

$sql = "SELECT
            organization.org_name,
            organization.org_code
        FROM
            organization
        WHERE
            organization.agency_code = $agency_code $query_string";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_organization_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
//echo "$sql";
$data = array();
$data[] = array(
    'text' => "Select Organization",
    'value' => 0
);
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['org_name'],
        'value' => $row['org_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>
