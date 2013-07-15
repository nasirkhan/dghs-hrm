<?php
require_once '../configuration.php';

$sql = "SELECT `org_type_name`, `org_type_code` FROM `org_type` ORDER BY org_type_name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_org_type_name:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['org_type_name'],
        'value' => $row['org_type_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>
