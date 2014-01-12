<?php

require_once '../configuration.php';

$dis_code = mysql_real_escape_string($_POST['dis_code']);

$sql = "SELECT
            upazila_bbs_code,
            upazila_name
        FROM
            `admin_upazila`
        WHERE
            upazila_district_code = $dis_code
        AND upazila_active LIKE 1
        ORDER BY
            upazila_name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_upazila_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
$data[] = array(
    'text' => "__ Select Upazila __",
    'value' => 0
);
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['upazila_name'],
        'value' => $row['upazila_bbs_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>
