<?php
require_once '../configuration.php';

$sql = "SELECT `laundry_system_name`, `laundry_system_code` FROM `org_laundry_system`";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['laundry_system_name'],
        'value' => $row['laundry_system_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>
