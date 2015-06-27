<?php

//get_org_district_name

require_once '../configuration.php';

$div_name = mysql_real_escape_string($_GET['div_name']);


$sql = "SELECT admin_division.division_bbs_code FROM admin_division WHERE division_name LIKE \"$div_name\"";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_org_district_name:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
$data = mysql_fetch_assoc($result);
$division_bbs_code = $data['division_bbs_code'];


$sql = "SELECT
                admin_district.district_bbs_code,
                admin_district.district_name
        FROM
                admin_district
        WHERE
                division_bbs_code = '$division_bbs_code'
        ORDER BY
                district_name";
$result = mysql_query($sql) or die(mysql_error() . "\n\nCode:<b>get_org_district_name:2\n\nQuery:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['district_name'],
        'value' => $row['district_bbs_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>
