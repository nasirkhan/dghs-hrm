<?php

require_once '../configuration.php';

$agency_code = (int) mysql_real_escape_string($_POST['agency_code']);
$div_code = (int) mysql_real_escape_string($_POST['div_code']);
$dis_code = (int) mysql_real_escape_string($_POST['dis_code']);
$upa_code = (int) mysql_real_escape_string($_POST['upa_code']);

//$org_type_code = (int) mysql_real_escape_string($_POST['org_type_code']);

$query_string = "";


if ($upa_code > 0){
    $query_string = " AND organization.upazila_thana_code = $upa_code";
}
else if ($dis_code > 0){
    $query_string = " AND organization.district_code = $dis_code";
}
else if ($div_code > 0){
    $query_string = " AND organization.district_code = $div_code";
}

//if ($org_type_code > 0 ){
//    $query_string = " AND organization.org_type_code = $org_type_code";
//}
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
