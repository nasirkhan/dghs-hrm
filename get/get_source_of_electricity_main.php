<?php
require_once '../configuration.php';

$sql = "SELECT `electricity_source_name`, `electricity_source_code` FROM `org_source_of_electricity_main`";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['electricity_source_name'],
        'value' => $row['electricity_source_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>