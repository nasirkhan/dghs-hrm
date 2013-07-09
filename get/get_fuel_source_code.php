<?php
require_once '../configuration.php';

$sql = "SELECT `fuel_source_name`, `fuel_source_code` FROM `org_fuel_source`";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['fuel_source_name'],
        'value' => $row['fuel_source_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>
