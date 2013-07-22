<?php
//get_org_upazila_thana_name

require_once '../configuration.php';

$div_name = mysql_real_escape_string($_GET['div_name']);

$sql = "SELECT
admin_division.division_bbs_code
FROM
admin_division
";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_org_upazila_thana_name:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");
$division_bbs_code = mysql_fetch_assoc($division_bbs_code);


$sql = "SELECT
admin_upazila.upazila_name,
admin_upazila.upazila_bbs_code
FROM
admin_upazila
order by
admin_upazila.upazila_name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_org_upazila_thana_name:2</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['upazila_name'],
        'value' => $row['upazila_bbs_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>
