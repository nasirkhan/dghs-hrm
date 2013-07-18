<?php
require_once '../configuration.php';

$sql = "SELECT
org_special_service.org_special_service_code,
org_special_service.org_special_service_name
FROM
org_special_service ORDER BY org_special_service_name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>get_special_service_code:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['org_special_service_name'],
        'value' => $row['org_special_service_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>
