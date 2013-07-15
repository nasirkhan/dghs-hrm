<?php
require_once '../configuration.php';

$sql = "SELECT `org_agency_code`, `org_agency_name` FROM `org_agency_code` ORDER BY org_agency_name";
$result = mysql_query($sql) or die(mysql_error() . "<br /><br />Code:<b>checkPasswordIsCorrect:1</b><br /><br /><b>Query:</b><br />___<br />$sql<br />");

$data = array();
while ($row = mysql_fetch_array($result)) {
    $data[] = array(
        'text' => $row['org_agency_name'],
        'value' => $row['org_agency_code']
    );
}
$json_data = json_encode($data);

print_r($json_data);
?>
