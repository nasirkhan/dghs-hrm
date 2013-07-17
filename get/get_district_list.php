<?php

require_once '../configuration.php';

$div_id = $_POST['div_id'];

$sql = "SELECT 
            admin_district.district_bbs_code,
            admin_district.old_district_id,
            admin_district.district_name
        FROM
            admin_district
        WHERE
            admin_district.division_id =$div_id
        ORDER BY
            admin_district.district_name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_district_list:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
$data[] = array(
    'text' => "Select District",
    'value' => 0
);
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['district_name'],
        'value' => $row['old_district_id']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>
