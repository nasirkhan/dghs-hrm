<?php
require_once '../configuration.php';

$sql = "SELECT `waste_disposal_system_name`, `waste_disposal_system_code` FROM `org_waste_disposal_system`";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['waste_disposal_system_name'],
        'value' => $row['waste_disposal_system_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>
