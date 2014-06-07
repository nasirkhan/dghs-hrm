<?php

//get_org_list
require_once '../configuration.php';

$div_code = (int) mysql_real_escape_string($_POST['div_code']);
$dis_code = (int) mysql_real_escape_string($_POST['dis_code']);
$upa_code = (int) mysql_real_escape_string($_POST['upa_code']);
$type_code = (int) mysql_real_escape_string($_POST['org_type']);

$query_string = "";
if ($upa_code > 0) {
    $query_string .= " AND organization.upazila_code = $upa_code";
}
if ($dis_code > 0) {
    $query_string .= " AND organization.district_code = $dis_code";
}
if ($div_code > 0) {
    $query_string .= " AND organization.division_code = $div_code";
}
if ($type_code > 0) {
    $query_string .= " AND organization.org_type_code = '" . $type_code . "'";
}
$query_string .= " ORDER BY org_name";

$sql = "SELECT
            organization.org_name,
            organization.org_code
        FROM
            organization
        WHERE
            `active` LIKE '1'
            AND org_code > 0
            AND org_name != ''
            $query_string";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_org_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
//echo "$sql";

$data = array();
$data[] = array(
    'text' => "> Select Organization",
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
