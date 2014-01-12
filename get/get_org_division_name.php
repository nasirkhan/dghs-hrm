<?php
require_once '../configuration.php';

$sql = "SELECT `division_name`, `division_bbs_code` FROM `admin_division` ORDER BY division_name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_org_division_name:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['division_name'],
        'value' => $row['division_bbs_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>
