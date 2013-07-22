<?php
require_once '../configuration.php';

$sql = "SELECT `org_location_type_code`, `org_location_type_name` FROM `org_location_type` ORDER BY org_location_type_name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['org_location_type_name'],
        'value' => $row['org_location_type_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>
